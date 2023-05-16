<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\DailyWaterResource;
use App\Models\DailyCaffeine;
use App\Models\DailyWater;
use Illuminate\Http\Request;

class DailyWaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return DailyWaterResource::collection(DailyWater::all());
        });
    }
}
