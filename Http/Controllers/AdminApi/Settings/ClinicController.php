<?php

namespace App\Http\Controllers\AdminApi\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Settings\ClinicRequest;
use App\Http\Resources\AdminApi\Settings\AdminClinicResource;
use App\Models\Activity;
use App\Models\Clinic;

class ClinicController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Clinic::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Clinic::orderBy('id','asc')->get();
        return response()->success(
            data: AdminClinicResource::collection($activities)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Clinic $clinic
     * @return \Illuminate\Http\Response
     */
    public function update(ClinicRequest $request,Clinic $clinic)
    {
        return $this->withErrorHandling(function () use ($request,$clinic) {
            foreach($request->items as $item){
                Clinic::findOrFail($item['id'])->update([
                    'location'=> $item['location'],
                ]);
            }
            return response()->success(0, null, [], 201);
        });
    }
}
