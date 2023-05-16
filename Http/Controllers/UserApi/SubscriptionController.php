<?php

namespace App\Http\Controllers\UserApi;

use App\Enum\MeetStatusEnum;
use App\Enum\SubscriptionPaymentMethodEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserApi\Iyzico\PaymentController;
use App\Http\Requests\UserApi\User\SubscriptionStoreRequest;
use App\Http\Requests\UserApi\User\SubscriptionApproveRequest;
use App\Http\Resources\BeforeAfterResource;
use App\Http\Resources\User\PastBeforeAfterResource;
use App\Http\Resources\User\ClinicResource;
use App\Http\Resources\User\SubscriptionResource;
use App\Http\Resources\User\ActiveSubscriptionResource;
use App\Models\BeforeAfter;
use App\Models\Report;
use App\Models\Subscription;
use App\Models\User;
use App\Models\SubscriptionSession;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionSession;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return SubscriptionResource::collection(auth()->user()->subscriptions);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\UserSubscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(UserSubscription $subscription)
    {
        return $this->withErrorHandling(function () use ($subscription) {
            return SubscriptionResource::make($subscription);
        });
    }

    public function activeSubscription(Subscription $subscription)
    {
        return $this->withErrorHandling(function () use ($subscription) {
            $activeSub = auth()->user()->activeSubscription();
            if (!$activeSub) return null;
            return ActiveSubscriptionResource::make($activeSub);
        });
    }
    public function store(SubscriptionStoreRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $subscription = Subscription::find($request->subscription_id);

            $userSubscription = UserSubscription::create([
                'subscription_id' => $subscription->id,
                'user_id' => auth()->user()->id,
                'name' => $subscription->name,
                'subscription_category' => $subscription->subscription_category,
                'payment_method' => $request->payment_method == 0 ? SubscriptionPaymentMethodEnum::online()->value :
                    SubscriptionPaymentMethodEnum::transfer()->value,
                'price' => $subscription->price,
                'status' => $request->payment_method == 0 ? SubscriptionStatusEnum::waitingPayment()->value :
                    SubscriptionStatusEnum::waitingApproval()->value,
                'vip' => $subscription->vip,
                'vip_subscription_id' => $subscription->vip_subscription_id,
                'spec_description' => $subscription->spec_description,
                'subscription_days' => $subscription->subscription_days,
                'start_at' => date(now()),
                'end_at' => date(now()->addMonth(1)),
            ]);
            if ($request->payment_method == 0) {
                $paymentController = new PaymentController();
                $paymentController->pay($userSubscription);
            }
        });
    }

    public function subscriptionCreateComplete($subscription_id){
        $userSubscription = UserSubscription::find($subscription_id);
        $userSubscription->update([
            'status' =>SubscriptionStatusEnum::active()->value
        ]);
        $report = $userSubscription->reports()->create([
            'total_fat_rate_change' =>0,
            'weight_change'=>0,
            'water_consumption'=>0,
            'user_id'=>$userSubscription->user_id,
            'date'=>now(),
        ]);
        foreach ($userSubscription->sessions as $key => $session) {
            UserSubscriptionSession::create([
                'session_type' => $session->session_type,
                'order' => $session->order,
                'user_subscription_id' => $userSubscription->id,
            ]);
            $start_at = re_date_meet(now()->addWeek($key),$userSubscription->subscription_days);
            $session->meet()->create([
                'user_id'=>$userSubscription->user_id,
                'type_id'=>$userSubscription->session_type,
                'start_at'=>$start_at,
                'end_at'=>$start_at->addMinute(60),
                'status'=>MeetStatusEnum::pendingAssignment()->value,
            ]);
            $report->weeklyReport()->create([
                'total_fat_rate_change'=>0,
                'weight_change'=>0,
                'water_consumption'=>0,
                'session_id'=>$session->id,
                'date'=>null,
            ]);
        }
    }

    public function addBeforeAfter(UserSubscriptionSession $session, Request $request)
    {
            $image = ImageManagerStatic::make($request->thumb);
            $session->addMedia($request->thumb)->toMediaCollection('original');
            $image = $image->resize(570, 690);
            $canvas = ImageManagerStatic::canvas(1150, 690);
            $lefImage = $session->subscription->sessions()->where('order', 1)->first()->getFirstMediaUrl('original');
            $canvas = $canvas->insert($lefImage, 'left');
            $canvas = $canvas->insert($image, 'right');
            $canvas->save('before_after.png');
            $file = public_path('before_after.png');
            $session->addMedia($file)->toMediaCollection('before_after');

            return BeforeAfterResource::make($session);
    }

    public function getBeforeAfter()
    {
        return $this->withErrorHandling(function () {
            $result = auth()->user()->activeSubscription();
            return $before_afters = BeforeAfterResource::collection($result->sessions);
        });
    }

    public function getPastBeforeAfter()
    {
        return $this->withErrorHandling(function () {
            $result = auth()->user()->pastSubscriptions();
            return $before_afters = PastBeforeAfterResource::collection($result);
        });
    }

    public function getPastSubscriptions()
    {
        return $this->withErrorHandling(function () {
            return SubscriptionResource::collection(auth()->user()->pastSubscriptions());
        });
    }

}
