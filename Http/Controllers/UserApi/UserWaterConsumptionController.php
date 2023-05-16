<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserApi\User\UserWaterConsumptionRequest;
use App\Http\Resources\User\UserWaterConsumptionResource;
use App\Models\Diet;
use App\Models\User;
use App\Models\UserWaterConsumption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserWaterConsumptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return UserWaterConsumptionResource::collection(auth()->user()->waterConsumption()->get());
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserWaterConsumption  $userWaterConsumption
     * @return \Illuminate\Http\Response
     */
    public function show(UserWaterConsumption $userWaterConsumption)
    {
        return $this->withErrorHandling(function () use($userWaterConsumption){
            return UserWaterConsumptionResource::make($userWaterConsumption);
        });
    }

    public function showByDay()
    {
        return $this->withErrorHandling(function () {
            $userWaterConsumptions = UserWaterConsumption::where('user_id', auth()->user()->id)->get(['liter', 'date']);

            $groups = $userWaterConsumptions->groupBy(function ($val) {
                return $val->date->format('d-m-y');
            })->sortByDesc('date');

            $groupWithSum = $groups->map(function ($group) {
                return [
                    'liters' => $group->sum('liter'),
                ];
            });

            return response()->success(
                data: $groupWithSum
            );
        });
    }

    public function showToday()
    {
        return $this->withErrorHandling(function () {
            return response()->success(
                data: UserWaterConsumptionResource::collection(UserWaterConsumption::where('user_id', auth()->user()->id)->whereDate('date', Carbon::now())->get())
            );
        });
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserWaterConsumptionRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {

            $sessions = auth()->user()->activeSubscription()?->sessions()->get();
            $id = null;
            foreach($sessions as $session){
                if( count($session->meet->where('start_at', '<=', Carbon::now())->where('end_at', '>=', Carbon::now())->get()) != 0 ){
                    $id = $session->meet->id;
                }
            }

            auth()->user()->waterConsumption()->create(
                [
                    'liter' => $request->post('liter'),
                    'date' =>  now(),
                    'user_subscription_session_id' => $id,
                ]);
            return response()->success(0, null, [], 201);
        });
    }

}
