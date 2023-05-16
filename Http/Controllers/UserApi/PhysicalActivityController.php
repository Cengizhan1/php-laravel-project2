<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\PhysicalActivityResource;
use App\Models\PhysicalActivity;

class PhysicalActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return PhysicalActivityResource::collection(PhysicalActivity::all());
        });
    }


}
