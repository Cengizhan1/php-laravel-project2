<?php

namespace App\Http\Controllers\AdminApi\Calendar;

use App\Enum\MeetStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Calendar\MeetRequest;
use App\Http\Requests\AdminApi\Calendar\MeetUpdateRequest;
use App\Http\Requests\AdminApi\Home\DateFilterRequest;
use App\Http\Resources\AdminApi\Calendar\MeetResource;
use App\Models\Meet;
use Illuminate\Http\Request;

class MeetController extends Controller
{

    public function __construct()
    {
//        $this->authorizeResource(Meet::class);
    }


    public function index(DateFilterRequest $request)
    {
        return MeetResource::collection(Meet::where('start_at', '>=', now()->subDay(now()->day))->
        where('end_at', '<=', now()->addDay($request->date_by - now()->day))->datatable());
    }

    public function show(Meet $meet)
    {
        return $this->withErrorHandling(function () use ($meet) {
            $result = MeetResource::make($meet);
            return response()->success(0, null, $result, 201);
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            foreach ($request->meets as $meet){
                 $meet = Meet::create([
                    'user_id' => $meet['user_id'],
                    'type_id' =>  $meet['meet_type'],
                    'start_at'=>$request->start_at,
                    'end_at'=>$request->end_at,
                    'status'=>MeetStatusEnum::active()->value,
                    'join_code' => uniqid(),
                ]);
            }
            $user = $meet->user;
            Notification::send($user, new TourNotification('RO ME','Yeni Bir Randevunuz var.'));
            return response()->success(0, null, [], 201);
        });
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meet  $meet
     * @return \Illuminate\Http\Response
     */
    public function meetsUpdate(MeetUpdateRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            foreach ($request->meets as $item){
                $meet = Meet::find($item['meet_id']);
                $meet->update([
                    'user_id' => $meet['user_id'],
                    'type_id' =>  $meet['meet_type'],
                    'start_at'=>$request->start_at,
                    'end_at'=>$request->end_at,
                    'status'=>MeetStatusEnum::active()->value,
                ]);
            }
            return response()->success(0, null, [], 201);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meet  $meet
     * @return \Illuminate\Http\Response
     */
    public function meetsDelete(Request $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            foreach ($request->meets as $meet_id){
                $meet = Meet::find($meet_id);
                $meet->sessions()->update([
                    'meet_id'=>null
                ]);
                $meet->comments()->delete();
                $meet->delete();
            }
            return response()->success(0, null, [0], 201);
        });
    }
}
