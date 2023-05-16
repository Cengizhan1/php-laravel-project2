<?php

namespace App\Http\Controllers\AdminApi\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Settings\EatingHabitRequest;
use App\Http\Requests\AdminApi\Settings\JobRequest;
use App\Http\Resources\AdminApi\Settings\AdminEatingHabitResource;
use App\Http\Resources\AdminApi\Settings\AdminJobResource;
use App\Models\EatingHabit;
use App\Models\Job;

class EatingHabitController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(EatingHabit::class);
//        $this->authorizeResource(Job::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = EatingHabit::orderBy('id','asc')->get();
        return response()->success(
            data: AdminEatingHabitResource::collection($items)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EatingHabitRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $locale = app()->getLocale();

            foreach ($request->items as $item) {
                if ($item['operation_type'] == 0) {
                    $duplicate = 0;
                    $lang_check = EatingHabit::where('name->'.$locale, $item['name'])->get();
                    if (count($lang_check) != 0) {
                        $duplicate = 1;
                    }
                    if($duplicate == 0){
                        EatingHabit::create([
                            'name' => $item['name'],
                        ]);
                    }
                } elseif ($item['operation_type'] == 1) {
                    $duplicate = 0;
                    $lang_check = EatingHabit::where('name->'.$locale, $item['name'])->get();
                    if (count($lang_check) != 0) {
                        $duplicate = 1;
                    }
                    if($duplicate == 0){
                        EatingHabit::findorfail($item['id'])->update([
                            'name' => $item['name'],
                        ]);
                    }
                } elseif ($item['operation_type'] == 2) {
                    EatingHabit::findorfail($item['id'])->delete();
                }
            }
            return response()->success(0, null, [], 201);
        });
    }
}
