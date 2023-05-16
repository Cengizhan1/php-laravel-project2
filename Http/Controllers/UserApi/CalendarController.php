<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminApi\Calendar\MeetResource;
use App\Http\Resources\User\Calendar\UserMeetResource;
use App\Http\Resources\User\ClinicResource;
use App\Models\Clinic;
use App\Models\Meet;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return UserMeetResource::collection(auth()->user()->meets()->where('start_at','>=',now())->get());
        });
    }
    public function pastMeets()
    {
        return $this->withErrorHandling(function () {
            return UserMeetResource::collection(auth()->user()->meets()->where('start_at','<',now())->get());
        });
    }
    public function currentMeet(Request $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $day = Carbon::createFromFormat('Y-m-d',  $request->filter_date);
            return UserMeetResource::collection(auth()->user()->meets()->whereDate('start_at', '=' ,$day)->get());
        });
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meet  $meet
     * @return \Illuminate\Http\Response
     */
    public function show(Meet $meet)
    {
        return $this->withErrorHandling(function () use($meet){
            return UserMeetResource::make($meet);
        });
    }
}
