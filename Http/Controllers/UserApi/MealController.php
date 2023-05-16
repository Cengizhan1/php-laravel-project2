<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserApi\User\AddMealImageRequest;
use App\Http\Resources\User\MealResource;
use App\Http\Requests\ThumbRequest;
use App\Models\Meal;
use App\Models\MealNutrient;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->withErrorHandling(function () {
            $currentMeal = auth()->user()->activeSubscription()?->diets
                ->where('status',0)->first()?->meals;
            return MealResource::collection($currentMeal);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        return $this->withErrorHandling(function () use($meal){
            return MealResource::make($meal);
        });
    }
    
    public function current(){
        return $this->withErrorHandling(function () {
            $currentMeal = auth()->user()->activeSubscription()?->diets
                ->where('status',0)->first()?->meals()?->where('start_at','>=',now())->first();
            if(!$currentMeal) return null;
            return MealResource::make($currentMeal);
        });
    }

    public function addMealImage(AddMealImageRequest $request)
    {
        return $this->withErrorHandling(function () use($request) {
            $meal = Meal::findOrFail($request->meal_id);

            $result = MealNutrient::create([
                'nutrient_id' => $request->nutrient_id,
                'alternative_nutrient_id' => $request->alternative_nutrient_id,
                'is_consumed' => $request->is_consumed,
                'meal_id' => $request->meal_id,
            ]);

            if($request->thumb){
                $meal->addMedia($request->thumb)->toMediaCollection('meal_image_user');
            }

            return response()->success(0, null, $meal->id, 201);
        });
    }

    public function addMealImageAlone(ThumbRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            
            $object = Meal::findOrFail($request->object_id);
            if ($request->thumb) {
                $object->clearMediaCollection('meal_image_user');
                $object->addMedia($request->thumb)->toMediaCollection('meal_image_user');
            }
            return response()->success(0, null, [], 201);
        });
    }

    public function updateMealNutrients(Meal $meal){
        return $this->withErrorHandling(function () use($meal,$request) {

            if($request->thumb){
                $meal->addMedia($request->thumb)->toMediaCollection('meal_image_user');
            }

            return response()->success(0, null, $meal->id, 201);
        });
    }
}
