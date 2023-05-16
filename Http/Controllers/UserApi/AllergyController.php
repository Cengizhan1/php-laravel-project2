<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\AllergyResource;
use App\Models\Activity;
use App\Models\Allergy;
use Illuminate\Http\Request;

class AllergyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            return AllergyResource::collection(Allergy::all());
        });
    }

    public function store(Request $request)
    {
        return $this->withErrorHandling(function () use ($request){
            $user = auth()->user();
            $allergyIds = array();
            foreach($request->allergies as $allergies){
                $allergyIds[] = $allergies['id'];
            }
            $user->allergies()->attach($allergyIds);
            return response()->success(0, null, $user->allergies, 201);
        });
    }
}
