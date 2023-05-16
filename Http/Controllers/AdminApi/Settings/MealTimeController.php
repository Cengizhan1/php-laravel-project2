<?php

namespace App\Http\Controllers\AdminApi\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Settings\JobRequest;
use App\Http\Requests\AdminApi\Settings\MealTimeRequest;
use App\Http\Requests\AdminApi\Settings\PhysicalActivityRequest;
use App\Http\Requests\AdminApi\Settings\SleepPatternRequest;
use App\Http\Resources\AdminApi\Settings\AdminJobResource;
use App\Http\Resources\AdminApi\Settings\AdminMealTimeResource;
use App\Http\Resources\AdminApi\Settings\AdminPhysicalActivityResource;
use App\Http\Resources\AdminApi\Settings\AdminSleepPatternResource;
use App\Models\Job;
use App\Models\Meal;
use App\Models\MealTime;
use App\Models\PhysicalActivity;
use App\Models\SleepPattern;

class MealTimeController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Job::class);
//        $this->authorizeResource(Meal::class);
//        $this->authorizeResource(MealTime::class);
//        $this->authorizeResource(PhysicalActivity::class);
//        $this->authorizeResource(SleepPattern::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = MealTime::orderBy('id','asc')->get();
        return response()->success(
            data: AdminMealTimeResource::collection($item)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MealTimeRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $locale = app()->getLocale();

            foreach ($request->items as $item) {
                if ($item['operation_type'] == 0) {
                    $duplicate = 0;
                    $lang_check = MealTime::where('name->'.$locale, $item['name'])->get();
                    if (count($lang_check) != 0) {
                        $duplicate = 1;
                    }
                    if($duplicate == 0){
                        MealTime::create([
                            'name' => $item['name'],
                            'start_at' => $item['start_at'],
                            'end_at' => $item['end_at'],
                        ]);
                    }
                } elseif ($item['operation_type'] == 1) {
                    $duplicate = 0;
                    $lang_check = MealTime::where('name->'.$locale, $item['name'])->get();
                    if (count($lang_check) != 0) {
                        $duplicate = 1;
                    }
                    if($duplicate == 0){
                        MealTime::findorfail($item['id'])->update([
                            'name' => $item['name'],
                            'start_at' => $item['start_at'],
                            'end_at' => $item['end_at'],
                        ]);
                    }
                } elseif ($item['operation_type'] == 2) {
                    MealTime::findorfail($item['id'])->delete();
                }
            }
            return response()->success(0, null, [], 201);
        });
    }
}
