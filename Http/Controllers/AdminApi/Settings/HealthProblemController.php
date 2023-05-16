<?php

namespace App\Http\Controllers\AdminApi\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class HealthProblemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $user = User::findOrFail($request->user_id);
            if($request->health_problem){
                $result = $user->health_problems()->attach($request->health_problem);
            }

            return response()->success(0, null, $result, 201);
        });
    }
}
