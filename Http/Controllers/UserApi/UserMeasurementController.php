<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserApi\User\UserMeasurementRequest;
use App\Http\Resources\User\UserNoteResource;
use App\Http\Resources\User\UserMeasurementResource;
use App\Models\UserMeasurement;
use App\Http\Requests\ThumbRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserMeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return UserMeasurementResource::collection(auth()->user()->measurements()->get());
        });
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserMeasurement  $userMeasurement
     * @return \Illuminate\Http\Response
     */
    public function show(UserMeasurement $userMeasurement)
    {
        return $this->withErrorHandling(function () use ($userMeasurement) {
            return UserMeasurementResource::make($userMeasurement);
        });
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserMeasurementRequest $request)
    {
        
        return $this->withErrorHandling(function () use($request) {

            $sessions = auth()->user()->activeSubscription()?->sessions()->get();
            $id = null;
            foreach($sessions as $session){
                if( count($session->meet->where('start_at', '<=', Carbon::now())->where('end_at', '>=', Carbon::now())->get()) != 0 ){
                    $id = $session->meet->id;
                }
            }

            $measurements =  auth()->user()->measurements()->create([
                'user_id'=>auth()->user()->id,
                'date'=>$request->date ?? now(),
                'waist_circumference'=>$request->waist_circumference,
                'belly_circumference'=>$request->belly_circumference,
                'upper_arm_circumference'=>$request->upper_arm_circumference,
                'upper_leg_circumference'=>$request->upper_leg_circumference,
                'hip_circumference'=>$request->hip_circumference,
                'chest_circumference'=>$request->chest_circumference,
                'neck_circumference'=>$request->neck_circumference,
                'diet_compatibility_id'=>$request->diet_compatibility_id,
                'weekly_exercise_count_id'=>$request->weekly_exercise_count_id,
                'message'=>$request->message,
                'weight'=>$request->weight,
                'fat'=>$request->fat ?? 0,
                'extra_cases' => $request->extra_cases,
                'diet_compliance_status' => $request->diet_compliance_status,
                'weekly_exercise_status' => $request->weekly_exercise_status,
                'user_subscription_session_id' => $id,
            ]);

            if($request->thumb){
                $measurements->clearMediaCollection('before_after');
                $measurements->addMedia($request->thumb)->toMediaCollection('before_after');
            }

            return response()->success(0, null, $measurements->id, 201);
        });
    }

    public function storeUserMeasurementImage(ThumbRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            
            $object = UserMeasurement::findOrFail($request->object_id);

            if($object->user_id == auth()->user()->id){
                if ($request->thumb) {
                    $object->clearMediaCollection('user_measurements');
                    $object->addMedia($request->thumb)->toMediaCollection('user_measurements');
                }
            }

            return response()->success(0, null, $object, 201);
        });
    }

    public function currentMeasurement(Request $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $day = Carbon::createFromFormat('Y-m-d',  $request->filter_date);
            return UserMeasurementResource::collection(auth()->user()->measurements()->whereDate('date', '=' ,$day)->get());
        });
    }

}
