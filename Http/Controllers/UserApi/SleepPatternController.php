<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\SleepPatternResource;
use App\Models\SleepPattern;

class SleepPatternController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return SleepPatternResource::collection(SleepPattern::all());
        });
    }
}
