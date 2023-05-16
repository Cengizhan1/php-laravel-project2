<?php

namespace App\Http\Controllers\AdminApi\Dietician;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Dietician\NutrientIndexRequest;
use App\Http\Requests\AdminApi\Dietician\NutrientRequest;
use App\Http\Resources\AdminApi\Dietician\DietResource;
use App\Http\Resources\AdminApi\Dietician\NutrientIndexResource;
use App\Http\Resources\AdminApi\Dietician\NutrientShowResource;
use App\Http\Requests\ThumbRequest;
use App\Models\Diet;
use App\Models\Nutrient;
use Illuminate\Http\Request;

class NutrientController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Nutrient::class);
    }

    public function index(NutrientIndexRequest $request)
    {
        return NutrientIndexResource::collection(
            get_filtered_data(Nutrient::query(),$request)->datatable()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NutrientRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $nutrient = Nutrient::create([
                'name' => $request->name,
                'admin_id' => auth()->user()->id,
                'recipe_id' => $request->recipe_id,
                'alternative_group_id' => get_group_id($request->alternative_nutrients),
                'unit' => $request->unit,
                'calorie' => $request->calorie,
                'description' => $request->description,
                'date' => $request->date ?? now(),
                'vegan'=>$request->vegan,
                'vegetarian'=>$request->vegetarian,
                'pregnant'=>$request->pregnant,
                'suckle'=>$request->suckle,
                'suckle_week_information'=>$request->suckle_week_information,
                'pregnant_week_information'=>$request->pregnant_week_information,
                'blood_group'=>$request->blood_group ?? 0,
            ]);
            $nutrient->alergies_nutrients()->attach($request->alergies);
            $nutrient->disease()->attach($request->disease);
            return response()->success(0, null, $nutrient->id, 201);
        });
    }

    public function addNutrientImage(ThumbRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {

            $object = Nutrient::findOrFail($request->object_id);
            if ($request->thumb) {
                $object->clearMediaCollection('thumb');
                $object->addMedia($request->thumb)->toMediaCollection('thumb');
            }
            return response()->success(0, null, $object, 201);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nutrient  $nutrient
     * @return \Illuminate\Http\Response
     */
    public function show(Nutrient $nutrient)
    {
        return $this->withErrorHandling(function () use ($nutrient) {
            return NutrientShowResource::make($nutrient);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nutrient  $nutrient
     * @return \Illuminate\Http\Response
     */
    public function update(NutrientRequest $request, Nutrient $nutrient)
    {
        return $this->withErrorHandling(function () use ($request, $nutrient) {
            $nutrient->update([
                'name' => $request->name,
                'admin_id' => auth()->user()->id,
                'recipe_id' => $request->recipe_id,
                'alternative_group_id' => get_group_id($request->alternative_nutrients),
                'unit' => $request->unit,
                'calorie' => $request->calorie,
                'description' => $request->description,
                'date' => $request->date ?? $nutrient->date,
                'vegan'=>$request->vegan,
                'vegetarian'=>$request->vegetarian,
                'pregnant'=>$request->pregnant,
                'suckle'=>$request->suckle,
                'blood_group'=>$request->blood_group ?? 0,
                'suckle_week_information'=>$request->suckle_week_information,
                'pregnant_week_information'=>$request->pregnant_week_information,
                ]);
            $nutrient->alergies_nutrients()->detach();
            $nutrient->disease()->detach();
            $nutrient->alergies_nutrients()->attach($request->alergies);
            $nutrient->disease()->attach($request->disease);
            return response()->success(0, null, [], 201);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nutrient  $nutrient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nutrient $nutrient)
    {
        return $this->withErrorHandling(function () use ($nutrient) {
            $nutrient->delete();
            return response()->success(0, null, [], 201);
        });
    }
}
