<?php

namespace App\Http\Controllers\AdminApi\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Customer\UserMeasurementDateRequest;
use App\Http\Requests\AdminApi\Home\DateFilterRequest;
use App\Http\Resources\User\UserMeasurementResource;
use App\Models\User;
use App\Models\UserMeasurement;
use Carbon\Carbon;

class UserMeasurementController extends Controller
{
    public function index(User $user,UserMeasurementDateRequest $request)
    {
        return $this->withErrorHandling(function () use ($user,$request) {
            $measurement = $user->measurements()?->with('media')
                ->where('date',$request->date)->first();
            if ($measurement){
                return UserMeasurementResource::make($measurement);
            }else return null;

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

}
