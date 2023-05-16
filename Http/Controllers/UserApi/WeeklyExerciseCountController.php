<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\WeeklyExerciseCountResource;
use App\Models\WeeklyExerciseCount;

class WeeklyExerciseCountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return WeeklyExerciseCountResource::collection(WeeklyExerciseCount::all());
        });
    }
}
