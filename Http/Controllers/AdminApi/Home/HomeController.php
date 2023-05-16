<?php

namespace App\Http\Controllers\AdminApi\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Home\DateFilterRequest;
use App\Http\Requests\AdminApi\Subscription\SubscriptionRequest;
use App\Http\Resources\AdminApi\CustomerIndexResource;
use App\Http\Resources\AdminApi\Home\HomeSaleResource;
use App\Http\Resources\AdminApi\Home\HomeWaitingActionsResource;
use App\Http\Resources\AdminApi\Home\MealPhotoExpectedResource;
use App\Http\Resources\AdminApi\Home\AwaitingApprovalResource;
use App\Http\Resources\AdminApi\Home\ContactFormResource;
use App\Http\Resources\AdminApi\Home\ContactResource;
use App\Http\Resources\AdminApi\Home\LogResource;
use App\Http\Resources\User\SubscriptionResource;
use App\Models\BeforeAfter;
use App\Models\Contact;
use App\Models\Meal;
use App\Models\Subscription;
use App\Models\SubscriptionComment;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

class HomeController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(UserSubscription::class);
//        $this->authorizeResource(Meal::class);
//        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales(DateFilterRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $chartData = array();
            $model = UserSubscription::
            where('start_at', '>=', now()->subDay($request->date_by))->whereIn('status', [0, 6, 7])->get();
            foreach ($model->chunk($request->date_by) as $key => $items) {
                $chartData[] = [
                    'count' => $items->sum('price')
                ];
            }
            return
                [
                    $chartData,
                    new HomeSaleResource($model)
                ];
        });
    }

    public function evaluations(DateFilterRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $subscription_commnets = SubscriptionComment::where('created_at', '>=', now()->subDay($request->date_by))
            ->get();
            return collect([
                'dietician' => $subscription_commnets->avg('dietician') ?? 0,
                'callCenter' => $subscription_commnets->avg('call_center') ?? 0,
                'dietDetox' => $subscription_commnets->avg('diet') ?? 0,
                'general' => $subscription_commnets->avg('general') ?? 0,
            ]);
        });
    }

    public function waitingActions(DateFilterRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $model = UserSubscription::where('start_at', '>=', now()->subDay($request->date_by))
                ->where('status', 7)->datatable();
            return [
                'count' => $model->count(),
                'data' => HomeWaitingActionsResource::collection($model)
            ];
        });
    }

    public function beforeAfters(DateFilterRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $model = User::all()->filter(function ($item) {
                return $item->isAddedBeforeAfter != null;
            });
            return [
                'count' => $model->count(),
                'data' => CustomerIndexResource::collection($model)
            ];
        });
    }

    public function mealPhotoExpected(DateFilterRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $model = Meal::whereDoesntHave('media')->
            where('start_at', '>=', now()->subDay($request->date_by))->datatable();
            return [
                'count' => $model->count(),
                'data' => MealPhotoExpectedResource::collection($model)
            ];
        });
    }

    public function awaitingApproval(DateFilterRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $model = UserSubscription::where('start_at', '>=', now()->subDay($request->date_by))
                ->where('status', 3)->datatable();
            return [
                'count' => $model->count(),
                'data' => AwaitingApprovalResource::collection($model)
            ];
        });
    }

    public function newCustomers(DateFilterRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $model = User::where('created_at', '>=', now()->subDay($request->date_by))->datatable();
            return [
                'count' => $model->count(),
                'data' => CustomerIndexResource::collection($model)
            ];
        });
    }

    public function contactForms(DateFilterRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $model = Contact::where('seen', false)->where('created_at', '>=', now()->subDay($request->date_by))->datatable();
            return [
                'count' => $model->count(),
                'data' => ContactFormResource::collection($model)
            ];
        });
    }

    public function contactFormsDetail(Contact $contact)
    {
        return $this->withErrorHandling(function () use ($contact) {
            $result = $contact->update([
                'seen' => true,
            ]);
            return ContactResource::make($contact);
        });
    }


    public function getLogs(DateFilterRequest $request)
    {
        return LogResource::collection(SpatieActivity::where('created_at', '>=', now()->subDay($request->date_by))->orderBy('created_at', 'DESC')->datatable());
    }

}
