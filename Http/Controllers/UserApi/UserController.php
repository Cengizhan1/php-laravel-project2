<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserApi\User\PermissionRequest;
use App\Http\Requests\UserApi\User\UpdateRequest;
use App\Http\Resources\User\UserNotificationResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        return $this->withErrorHandling(function () {
            return new UserResource(auth()->user());
        });
    }

    public function update(UpdateRequest $request)
    {

        return $this->withErrorHandling(function () use ($request) {
            $user = $request->user('user')->update(
                [
                    'first_name' => $request->get('first_name'),
                    'last_name' => $request->get('last_name'),
                    'email' => $request->get('email'),
                    'birth_date'=>$request->get('birth_date'),
                    'firebase_device_token' => $request->get('firebase_device_token'),
                    'registration_completed' => true,
                    'last_active_at' => now(),
                    'gender'=>$request->get('gender'),
                ]);

            auth()->user()->information()->first()->update([
                'user_id'=>auth()->user()->id,
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

            if($request->diseases){
                auth()->user()->diseases()->attach($request->diseases);
            }

            if($request->allergies){
                auth()->user()->allergies()->attach($request->allergies);
            }

            if($request->health_problem){
                auth()->user()->health_problems()->attach($request->health_problem);
            }
//            if ($request->thumb) {
//                $request->user('customer')->clearMediaCollection('avatar');
//                $request->user('customer')->addMedia($request->thumb)->toMediaCollection('avatar');
//            }
            return response()->success(0,null,new UserResource($request->user()),201);
        });
    }


    protected function withErrorHandling2($callback)
    {
        try {
            return $callback();
        } catch (\Exception $exception) {
            return response()->error(
                code: $exception->getCode(),
                message: $exception->getMessage(),
                data: [],
                status: 500
            );
        }
    }

    public function storeUserImage(Request $request)
    {
        return $this->withErrorHandling(function () use ($request) {

            $object = auth()->user();
            if ($request->thumb) {
                $object->clearMediaCollection('avatar');
                $object->addMedia($request->thumb)->toMediaCollection('avatar');
            }

            return response()->success(0, null, [], 201);
        });
    }

    public function deviceToken(Request $request)
    {
        return $this->withErrorHandling(function ()use($request){
            auth()->user()->update([
                'firebase_device_token'=>$request->deviceToken
            ]);
        });
    }

    public function permission(PermissionRequest $request){

        return $this->withErrorHandling(function () use ($request) {
            $permission = auth()->user()->permission()->first()->update(
                [
                    'sms_notification' => $request->post('sms_notification'),
                    'email_notification' => $request->post('email_notification'),
                    'app_notification' => $request->post('app_notification'),
                ]);
            return response()->success(0,null, UserNotificationResource::make(auth()->user()->permission()->first()),201);
        });
    }
    public function destroy(){

        return $this->withErrorHandling(function () {
            auth()->user()->permission()->delete();
            auth()->user()->information()->delete();
            auth()->user()->waterConsumption()->delete();
            auth()->user()->notes()->delete();
            auth()->user()->diets()->delete();
            auth()->user()->measurements()->delete();
            auth()->user()->forceDelete();
            return response()->success(0,null, [],201);
        });

    }
}
