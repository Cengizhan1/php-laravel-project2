<?php

namespace App\Http\Controllers\AdminApi\Subscription;

use App\Enum\SubscriptionCategoryEnum;
use App\Enum\SubscriptionPackageTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Subscription\SubscriptionRequest;
use App\Http\Requests\AdminApi\Subscription\SubscriptionUpdateRequest;
use App\Http\Resources\User\SubscriptionResource;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscriptionSession;
use App\Http\Resources\BeforeAfterResource;

use Intervention\Image\ImageManager;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Subscription::class, 'subscription');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function (){
            return SubscriptionResource::collection(Subscription::datatable());
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $subscription = Subscription::create([
                'name' => $request->name,
                'subscription_category' =>SubscriptionPackageTypeEnum::from($request->subscription_category)->value ,
                'price' => $request->price,
                'vip' => $request->vip ?? 0,
                'status'=>0,
                'vip_subscription_id' => $request->vip_subscription_id,
                'spec_description' => json_encode($request->spec_description),
                'subscription_days' => $request->subscription_days,

                'stopped_count' => $request->stopped_count,
                'stopped_limit' => $request->stopped_limit,
                'stopped_sessions' => $request->stopped_sessions,
            ]);

            foreach ($request->sessions as $key => $session) {
                $subscription->sessions()->create([
                    'session_type' => $session,
                    'order' => $key,
                ]);
            }
            return response()->success(0, null, $subscription->id, 201);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        return $this->withErrorHandling(function () use ($subscription) {
            return SubscriptionResource::make($subscription);
        });
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(SubscriptionUpdateRequest $request, Subscription $subscription)
    {
        return $this->withErrorHandling(function () use ($request, $subscription) {

            $subscription = $subscription->update([
                'name' => $request->name,
                'subscription_category' => $request->subscription_category,
                'price' => $request->price,
                'vip' => $request->vip ?? 0,
                'status'=> 0,
                'vip_subscription_id' => $request->vip_subscription_id,
                'spec_description' => implode("*****",$request->spec_description),
                'subscription_days' => $request->subscription_days,

                'stopped_count' => $request->stopped_count,
                'stopped_limit' => $request->stopped_limit,
                'stopped_sessions' => $request->stopped_sessions,
            ]);
            return response()->success(0, null, $subscription, 201);
        });
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



    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        return $this->withErrorHandling(function () use ($subscription) {
            $subscription->sessions()->detach();
            $subscription->delete();
            return response()->success(0, null, [$subscription->id], 201);
        });
    }

    public function getPastSubscriptions(User $user)
    {
        return $this->withErrorHandling(function () use ($user) {
            return SubscriptionResource::collection($user->pastSubscriptions());
        });
    }
}
