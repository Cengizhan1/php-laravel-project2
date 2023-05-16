<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\EatingHabitResource;
use App\Models\EatingHabit;

class EatingHabitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return EatingHabitResource::collection(EatingHabit::all());
        });
    }


}
