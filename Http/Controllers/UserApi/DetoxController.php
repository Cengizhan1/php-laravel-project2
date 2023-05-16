<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ClinicResource;
use App\Http\Resources\User\DetoxResource;
use App\Http\Resources\User\DietResource;
use App\Models\Clinic;
use App\Models\Detox;
use App\Models\Diet;
use Illuminate\Http\Request;

class DetoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return DetoxResource::collection(auth()->user()->diets()->where('package_type',1)->get());

        });
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Diet  $diet
     * @return \Illuminate\Http\Response
     */
    public function show(Detox $detox)
    {
        return $this->withErrorHandling(function () use($detox){
            return DetoxResource::make($detox);
        });
    }
    public function currentDetox()
    {
        return $this->withErrorHandling(function (){
            $diet = auth()->user()->activeSubscription()?->diets->first();
            if (!$diet) return null;
            return DetoxResource::make($diet);
        });
    }

}
