<?php

namespace App\Http\Controllers\AdminApi\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Customer\BeforeAfterRequest;
use App\Http\Requests\AdminApi\Customer\CommentRequest;
use App\Http\Requests\AdminApi\Customer\IndexRequest;
use App\Http\Resources\AdminApi\CustomerIndexResource;
use App\Http\Resources\AdminApi\CustomerShowResource;
use App\Http\Requests\UserApi\User\UpdateRequest;
use App\Http\Resources\BeforeAfterResource;
use App\Http\Resources\BeforeAfterNotCollapseResource;
use App\Http\Resources\User\MealResource;
use App\Http\Resources\User\SubscriptionCommentResource;
use App\Http\Resources\User\UserNoteResource;
use App\Http\Resources\User\UserSubscriptionResource;
use App\Models\SubscriptionComment;
use App\Models\User;
use App\Models\UserMeasurement;
use App\Models\UserSubscriptionSession;
use App\Models\UserWaterConsumption;

class CustomerController extends Controller
{

    public function __construct()
    {
//        $this->authorizeResource(User::class, 'customer');
    }

    public function index(IndexRequest $request)
    {
        $customers = User::whereAvailable();
        return CustomerIndexResource::collection(
            get_filtered_user($customers, $request)->datatable()
        );
    }

    public function seeingPastDiets(User $user)
    {
        return $this->withErrorHandling(function () use ($user) {
            $user->update([
                'can_see_past_diets' => !$user->can_see_past_diets
            ]);
            return response()->success(0, null, $user, 201);
        });
    }
    public function getUserPermission(User $user)
    {
        return $this->withErrorHandling(function () use ($user) {

            return response()->success(data:[
                'photo_share_permission'=>$user->photo_share_permission,
                'can_see_calorie'=>$user->can_see_calorie,
                'can_compare_diets'=>$user->can_compare_diets,
                'is_stopped_diet'=>$user->activeSubscription()?->stopped_at ?? false,
            ]);
        });
    }


    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $customer)
    {
        return $this->withErrorHandling(function () use ($customer) {
            return CustomerShowResource::make($customer);
        });
    }

    public function store(UpdateRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {

            $user = User::create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->get('email'),
                'birth_date' => $request->get('birth_date'),
                'firebase_device_token' => $request->get('firebase_device_token'),
                'registration_completed' => true,
                'last_active_at' => now(),
                'gender' => $request->get('gender'),
            ]);

            $user->information()->create([
                'user_id' => $user->id,
                'job_id' => $request->get('job_id'),
                'weight' => $request->get('weight'),
                'target_weight' => $request->get('target_weight'),
                'destination_id' => $request->get('destination_id'),
                'operation' => $request->get('operation'),
                'medicine' => $request->get('medicine'),
                'operation_description' => $request->get('operation_description'),
                'medicine_description' => $request->get('medicine_description'),
                'eating_habit_id' => $request->get('eating_habit_id'),
                'physical_activity_id' => $request->get('physical_activity_id'),
                'daily_caffeine_id' => $request->get('daily_caffeine_id'),
                'daily_water_id' => $request->get('daily_water_id'),
                'sleep_pattern_id' => $request->get('sleep_pattern_id'),
                'vegan' => $request->get('vegan'),
                'vegetarian' => $request->get('vegetarian'),
                'pregnant' => $request->get('pregnant'),
                'pregnant_week_count' => $request->get('pregnant_week_count'),
                'suckle' => $request->get('suckle'),
                'suckle_week_count' => $request->get('suckle_week_count'),
                'blood_group' => $request->get('blood_group'),
                'special_state' => $request->get('special_state'),
            ]);

            if ($request->diseases) {
                $user->diseases()->attach($request->diseases);
            }

            if ($request->allergies) {
                $user->allergies()->attach($request->allergies);
            }

            if ($request->health_problem) {
                $user->health_problems()->attach($request->health_problem);
            }

            return response()->success(0, null, $user, 201);
        });
    }

    public function customerUpdate(UpdateRequest $request, User $user)
    {
        return $this->withErrorHandling(function () use ($request, $user) {
            $result = $user->update([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->email ?? $user->email,
                'birth_date' => $request->get('birth_date'),
                'firebase_device_token' => $request->get('firebase_device_token'),
                'registration_completed' => true,
                'last_active_at' => now(),
                'gender' => $request->get('gender'),
            ]);
            $user->information()->first()->update([
                'user_id' => $user->id,
                'job_id' => $request->get('job_id'),
                'weight' => $request->get('weight'),
                'target_weight' => $request->get('target_weight'),
                'destination_id' => $request->get('destination_id'),
                'operation' => $request->get('operation'),
                'medicine' => $request->get('medicine'),
                'operation_description' => $request->get('operation_description'),
                'medicine_description' => $request->get('medicine_description'),
                'eating_habit_id' => $request->get('eating_habit_id'),
                'physical_activity_id' => $request->get('physical_activity_id'),
                'daily_caffeine_id' => $request->get('daily_caffeine_id'),
                'daily_water_id' => $request->get('daily_water_id'),
                'sleep_pattern_id' => $request->get('sleep_pattern_id'),
                'vegan' => $request->get('vegan'),
                'vegetarian' => $request->get('vegetarian'),
                'pregnant' => $request->get('pregnant'),
                'pregnant_week_count' => $request->get('pregnant_week_count'),
                'suckle' => $request->get('suckle'),
                'suckle_week_count' => $request->get('suckle_week_count'),
                'blood_group' => $request->get('blood_group'),
                'special_state' => $request->get('special_state'),
            ]);

            if ($request->diseases) {
                $user->diseases()->attach($request->diseases);
            }

            if ($request->allergies) {
                $user->allergies()->attach($request->allergies);
            }

            if ($request->health_problem) {
                $user->health_problems()->attach($request->health_problem);
            }

            return response()->success(0, null, $result, 201);
        });
    }

    public function userPastPackages(User $user)
    {
        return $this->withErrorHandling(function () use ($user) {
            $result = $user->pastSubscriptions();
            return UserSubscriptionResource::collection($result);
        });
    }

    public function getBeforeAfter(User $user, BeforeAfterRequest $request)
    {
        return $this->withErrorHandling(function () use ($user, $request) {
            $result = UserSubscriptionSession::whereHas('subscription', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })->when(
                $request->has('week'), function ($query) use ($request) {
                $query->where('order', $request->week);
            })->when(
                $request->has('package_id'), function ($query) use ($request) {
                $query->where('user_subscription_id', $request->package_id);
            })->get();
            return BeforeAfterResource::collection($result);
        });
    }

    public function getBeforeAfterNotCollage(User $user, BeforeAfterRequest $request)
    {
        return $this->withErrorHandling(function () use ($user, $request) {
            $result = UserSubscriptionSession::whereHas('subscription', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })->when(
                $request->has('week'), function ($query) use ($request) {
                $query->where('order', $request->week);
            })->when(
                $request->has('package_id'), function ($query) use ($request) {
                $query->where('user_subscription_id', $request->package_id);
            })->get();
            return BeforeAfterNotCollapseResource::collection($result);
        });
    }


    public function comments(CommentRequest $request)
    {
        return SubscriptionCommentResource::collection(SubscriptionComment::orderBy('created_at', 'desc')->when(
            $request->has('user_id'), function ($query) use ($request) {
            $query->whereHas('userSubscription', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            });
        })->when(
            $request->has('comment_rate'), function ($query) use ($request) {
            if ($request->comment_type == 0) {
                $query->where('dietician', '>=', $request->comment_rate);
            } else if ($request->comment_type == 1) {
                $query->where('call_center', '>=', $request->comment_rate);
            } else if ($request->comment_type == 2) {
                $query->where('diet', '>=', $request->comment_rate);
            } else {
                $query->where('general', '>=', $request->comment_rate);
            }
        })->datatable());
    }

    public function customerMeals(User $user)
    {
        return $this->withErrorHandling(function () use ($user) {
            $result = $user->diets;
            $meals = collect();
            foreach ($user->diets as $diet) {
                $meals->merge($diet->meals);
            }
            return MealResource::collection($meals);


        });
    }

    public function getReports(User $user){
        return $this->withErrorHandling(function () use ($user) {
           $reportCards = array();
           foreach ($user->subscriptions()->get() as $subscription){
               $measurements = UserMeasurement::whereBetween('date',[$subscription->start_at,$subscription->end_at])->get();
               $waterConsumptions = UserWaterConsumption::whereBetween('date',[$subscription->start_at,$subscription->end_at])->get();
               $reportCard = collect([
                   'total_fat_rate_change'=>$measurements->avg('fat'),
                   'weight_change'=>$measurements->avg('weight'),
                   'water_consumption'=>$waterConsumptions->avg('liter'),
                   'start_at'=>$subscription->start_at,
                   'end_at'=>$subscription->end_at,
                   'measurements'=>$measurements,
                   'waterConsumptions'=>$waterConsumptions,
               ]);
               $reportCards[] = $reportCard;
           }
           return $reportCards;
        });
    }

    public function destroy(User $user)
    {
        return $user->delete();
    }
}
