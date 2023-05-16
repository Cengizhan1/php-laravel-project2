<?php

namespace App\Http\Controllers\AdminApi\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Customer\StoreRequest;
use App\Http\Requests\AdminApi\Settings\ActivityRequest;
use App\Http\Resources\AdminApi\Settings\ActivityIndexResource;
use App\Models\Activity;
use App\Models\Role;

use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Gate;

class ActivityController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Activity::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = Activity::orderBy('id','asc')->get();
        return response()->success(
            data: ActivityIndexResource::collection($item)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $locale = app()->getLocale();

            foreach ($request->items as $item) {
                if ($item['operation_type'] == 0) {
                    $duplicate = 0;
                    $lang_check = Activity::where('name->'.$locale, $item['name'])->get();
                    if (count($lang_check) != 0) {
                        $duplicate = 1;
                    }
                    if ($duplicate == 0) {
                        Activity::create([
                            'name' => $item['name'],
                            'calorie' => $item['calorie'],
                            'weight_settings' => $item['weight_settings'],
                        ]);
                    }

                } elseif ($item['operation_type'] == 1) {
                    $duplicate = 0;
                    $lang_check = Activity::where('name->'.$locale, $item['name'])->get();
                    if (count($lang_check) != 0) {
                        $duplicate = 1;
                    }
                    if ($duplicate == 0) {
                        Activity::findorfail($item['id'])->update([
                            'name' => $item['name'],
                            'calorie' => $item['calorie'],
                            'weight_settings' => $item['weight_settings'],
                        ]);
                    }
                } elseif ($item['operation_type'] == 2) {
                    Activity::findorfail($item['id'])->delete();
                }
            }
            return response()->success(0, null, [], 201);
        });
    }

}
