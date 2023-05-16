<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HealthProblem;
use App\Http\Resources\User\HealthProblemResource;

class HealthProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return HealthProblemResource::collection(HealthProblem::all());
        });
    }
}
