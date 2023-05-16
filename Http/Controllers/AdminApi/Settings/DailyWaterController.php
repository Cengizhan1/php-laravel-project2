<?php

namespace App\Http\Controllers\AdminApi\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Settings\DailyWaterRequest;
use App\Http\Requests\AdminApi\Settings\JobRequest;
use App\Http\Requests\AdminApi\Settings\PhysicalActivityRequest;
use App\Http\Resources\AdminApi\Settings\AdminDailyWaterResource;
use App\Http\Resources\AdminApi\Settings\AdminJobResource;
use App\Http\Resources\AdminApi\Settings\AdminPhysicalActivityResource;
use App\Models\DailyWater;
use App\Models\Job;
use App\Models\PhysicalActivity;

class DailyWaterController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(DailyWater::class);
//        $this->authorizeResource(Job::class);
//        $this->authorizeResource(PhysicalActivity::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = DailyWater::orderBy('id','asc')->get();
        return response()->success(
            data: AdminDailyWaterResource::collection($item)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailyWaterRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $locale = app()->getLocale();

            foreach ($request->items as $item) {
                if ($item['operation_type'] == 0) {
                    $duplicate = 0;
                    $lang_check = DailyWater::where('name->'.$locale, $item['name'])->get();
                    if (count($lang_check) != 0) {
                        $duplicate = 1;
                    }
                    if($duplicate == 0){
                        DailyWater::create([
                            'name' => $item['name'],
                        ]);
                    }
                } elseif ($item['operation_type'] == 1) {
                    $duplicate = 0;
                    $lang_check = DailyWater::where('name->'.$locale, $item['name'])->get();
                    if (count($lang_check) != 0) {
                        $duplicate = 1;
                    }
                    if($duplicate == 0){
                        DailyWater::findorfail($item['id'])->update([
                            'name' => $item['name'],
                        ]);
                    }
                } elseif ($item['operation_type'] == 2) {
                    DailyWater::findorfail($item['id'])->delete();
                }
            }
            return response()->success(0, null, [], 201);
        });
    }
}
