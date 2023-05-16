<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserApi\User\UserActivityRequest;
use App\Http\Requests\UserApi\User\UserWaterConsumptionRequest;
use App\Http\Resources\User\UserCalorieResource;
use App\Models\Activity;
use App\Models\UserCalorie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\User\ActivityResource;

class ActivityController extends Controller
{
    public function index()
    {
        return $this->withErrorHandling(function () {

            return UserCalorieResource::collection(auth()->user()?->activities()->get());
        });
    }

    public function activityShowByDay()
    {
        return $this->withErrorHandling(function () {
            $user_calories = auth()->user()->activities()->get();

            $groupwithcount = $user_calories->map(function ($group) {
                return [
                    'date' => $group->date->format('y-m-d'),
                    'sum_calories' => $group->total_calorie,
                ];
            });

            $groups = $groupwithcount->groupBy('date');

            $result = $groups->map(function ($group) {
                return [
                    'sum_calorie' => $group->sum('sum_calories'),
                ];
            });

            return response()->success(
                data: $result
            );

        });
    }

    public function activityShowToday()
    {
        return $this->withErrorHandling(function () {
            return response()->success(
                // Buraya first değil get koyulacak bir günde birden fazla usercalorie olabilir hepsinin gelmesi lazım. bunları toplayarak getirmedim güne özel oldukları için.
                data: UserCalorieResource::collection(auth()->user()->activities()->whereDate('date', Carbon::now())->get())
            );
        });
    }
    public function store(UserActivityRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            auth()->user()->activities()->create(
                [
                    'activity_id' => $request->activity_id,
                    'time' => $request->time,
                    'date' => now(),
                    'user_subscription_session_id' => auth()->user()->activeSubscription()?->sessions()?->
                        where('start_at','>=',now())->orderByStartAt('asc')->first()?->id ?? null,
                ]);
            return response()->success(0, null, [], 201);
        });
    }
}
