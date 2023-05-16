<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\DiseaseResource;
use App\Models\Disease;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return DiseaseResource::collection(Disease::all());
        });
    }

    public function store(Request $request)
    {
        return $this->withErrorHandling(function () use ($request){
            activity()->log('Look mum, I logged something');

            $user = auth()->user();
            $diseaseIds = array();
            foreach($request->diseases as $disease){
                $diseaseIds[] = $disease['id'];
            }
            $user->diseases()->attach($diseaseIds);
            return response()->success(0, null, $user->diseases, 201);
        });
    }

}
