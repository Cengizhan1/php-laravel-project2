<?php

namespace App\Http\Controllers\AdminApi\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Settings\AllergieRequest;
use App\Http\Requests\AdminApi\Settings\JobRequest;
use App\Http\Resources\AdminApi\Settings\AdminAllergieResource;
use App\Http\Resources\AdminApi\Settings\AdminJobResource;
use App\Models\Allergy;
use App\Models\Job;

class AllergyController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Allergy::class);
//        $this->authorizeResource(Job::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {$items = Allergy::orderBy('id','asc')->get();
        return response()->success(
            data: AdminAllergieResource::collection($items)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AllergieRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $locale = app()->getLocale();

            foreach ($request->items as $item) {
                if ($item['operation_type'] == 0) {
                    $duplicate = 0;
                    $lang_check = Allergy::where('name->'.$locale, $item['name'])->get();
                    if (count($lang_check) != 0) {
                        $duplicate = 1;
                    }
                    if($duplicate == 0){
                        Allergy::create([
                            'name' => $item['name'],
                        ]);
                    }
                } elseif ($item['operation_type'] == 1) {
                    $duplicate = 0;
                    $lang_check = Allergy::where('name->'.$locale, $item['name'])->get();
                    if (count($lang_check) != 0) {
                        $duplicate = 1;
                    }
                    if($duplicate == 0){
                        Allergy::findorfail($item['id'])->update([
                            'name' => $item['name'],
                        ]);
                    }
                } elseif ($item['operation_type'] == 2) {
                    Allergy::findorfail($item['id'])->delete();
                }
            }
            return response()->success(0, null, [], 201);
        });
    }
}
