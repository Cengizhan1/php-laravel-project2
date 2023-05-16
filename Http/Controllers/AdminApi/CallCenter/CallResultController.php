<?php

namespace App\Http\Controllers\AdminApi\CallCenter;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminApi\CallResultResource;
use App\Models\CallDemand;
use App\Models\CallResult;
use App\Models\User;
use Illuminate\Http\Request;

class CallResultController extends Controller
{

    public function __construct()
    {
//        $this->authorizeResource(CallResult::class);
    }

    public function index(User $user)
    {
        return CallResultResource::collection($user->callResult()->datatable());
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
            $diet = CallResult::create([
                'user_id'=>$request->user_id,
                'admin_id'=>auth()->user()->id,
                'call_result_state' => $request->call_result_state, // Enum
                'note' => $request->note,
                'date' => $request->date,
            ]);
            return response()->success(0, null, $diet->id, 201);
        });
    }

}
