<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\DietCompatibilityResource;
use App\Models\Activity;
use App\Models\DietCompatibility;
use Illuminate\Http\Request;

class DietCompatibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return DietCompatibilityResource::collection(DietCompatibility::all());
        });
    }

}
