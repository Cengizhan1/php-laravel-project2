<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\DailyCaffeineResource;
use App\Models\Clinic;
use App\Models\DailyCaffeine;
use Illuminate\Http\Request;

class DailyCaffeineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return DailyCaffeineResource::collection(DailyCaffeine::all());
        });
    }
}
