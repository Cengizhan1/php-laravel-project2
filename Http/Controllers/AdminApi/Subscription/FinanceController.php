<?php

namespace App\Http\Controllers\AdminApi\Subscription;

use App\Enum\SubscriptionPaymentMethodEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Subscription\ChartRequest;
use App\Http\Requests\AdminApi\Subscription\FinanceIndexRequest;
use App\Http\Requests\AdminApi\Subscription\FinanceSubscriptionStoreRequest;
use App\Http\Requests\AdminApi\Subscription\ApproveTransferRequest;
use App\Http\Requests\AdminApi\Subscription\PaymentRequest;
use App\Http\Requests\UserApi\User\SubscriptionApproveRequest;
use App\Http\Resources\AdminApi\Finance\FinanceCustomerResource;
use App\Http\Resources\AdminApi\Finance\FinancePaymentResource;
use App\Http\Resources\AdminApi\Home\HomeWaitingActionsResource;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionSession;

class FinanceController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(User::class);
    }

    public function index(FinanceIndexRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            return FinanceCustomerResource::collection(get_filtered_user(UserSubscription::query(), $request)->datatable());
        });
    }

    public function chart(ChartRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $chartData = array();
            $model = UserSubscription::where('start_at', '>=', now()->subDay($request->date_by))
                ->where('subscription_category', $request->type)->get();
            foreach ($model->chunk($request->date_by) as $key => $items) {
                $chartData[] = [
                    'count' => $items->sum('price')
                ];
            }
            return response()->success(data: [
                'chartData' => $chartData,
                'users' => HomeWaitingActionsResource::collection($model),
            ]);
        });
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function userSubscriptionAssign(Subscription $subscription, FinanceSubscriptionStoreRequest $request)
    {
        return $this->withErrorHandling(function () use ($subscription, $request) {
            foreach ($request->customers as $customer) {
                $user = User::find($customer);
                $userSubscription = UserSubscription::create([
                    'subscription_id' => $subscription->id,
                    'user_id' => $user->user_id,
                    'name' => $subscription->name,
                    'subscription_category' => $subscription->subscription_category,
                    'payment_method' => SubscriptionPaymentMethodEnum::cash()->value,
                    'price' => $subscription->price,
                    'status' => SubscriptionStatusEnum::active(),
                    'vip' => $subscription->vip,
                    'vip_subscription_id' => $subscription->vip_subscription_id,
                    'spec_description' => $subscription->spec_description,
                    'subscription_days' => $subscription->subscription_days,
                    'start_at' => date(now()),
                    'end_at' => null,
                ]);
                foreach ($subscription->sessions as $session) {
                    UserSubscriptionSession::create([
                        'session_type' => $session->session_type,
                        'order' => $session->order,
                        'user_subscription_id' => $userSubscription->id,
                    ]);
                }
            }
            return response()->success(0, null, [], 201);
        });
    }

    public function subscriptionTransferApprove(SubscriptionApproveRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            if ($request->approve == true) {
                $controller = new \App\Http\Controllers\UserApi\SubscriptionController();
                $controller->subscriptionCreateComplete($request->subscription_id);
            } else {
                $userSubscription = UserSubscription::find($request->subscription_id);
                $userSubscription->update([
                    'status' => SubscriptionStatusEnum::transferDeclined()->value
                ]);
            }
        });
    }
    public function addPayment(UserSubscription $user,PaymentRequest $request){
        return $this->withErrorHandling(function () use ($user,$request) {
            $user->payments()?->create([
                'user_id'=>$user->id,
                'amount'=>$request->amount,
                'date'=>$request->date ?? now(),
            ]);
            return response()->success(0, null, [], 201);
        });
    }
    public function showCustomer(UserSubscription $user){
        return $this->withErrorHandling(function () use ($user) {
                $price = $user->price ?? 0;
                $remainingPrice = $user->remainingAmount ?? 0;
                $paid =$user->payments()?->sum('amount') ?? 0;
            return response()->success([
                'paid' => (integer)$paid,
                'remainingPayment' => (integer)$remainingPrice,
                'total' => (integer)$price,
                'percent' =>  $paid*100/$price,
                'payments' => FinancePaymentResource::collection($user->payments) ?? 0,
            ]);
        });
    }
}
