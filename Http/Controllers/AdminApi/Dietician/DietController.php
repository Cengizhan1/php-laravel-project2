<?php

namespace App\Http\Controllers\AdminApi\Dietician;

use App\Enum\SubscriptionPackageTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Dietician\DietRequest;
use App\Http\Requests\AdminApi\Dietician\DietIndexRequest;
use App\Http\Requests\AdminApi\Dietician\DetoxIndexRequest;
use App\Http\Resources\AdminApi\Dietician\DietResource;
use App\Http\Resources\AdminApi\Dietician\DietShowResource;
use App\Models\Diet;
use App\Models\DetoxCategory;
use App\Models\Meal;
use App\Models\MealNutrient;
use App\Models\MealTime;
use App\Models\TemplateDiet;
use Illuminate\Http\Request;

class DietController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(DetoxCategory::class, 'diet');
//        $this->authorizeResource(TemplateDiet::class, 'diet');
    }

    public function index(DietIndexRequest $request)
    {
        return DietResource::collection(
            get_filtered_data(TemplateDiet::query(),$request)->where('package_type',0)->datatable()
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DietRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $template_diet = TemplateDiet::create([
                'name' => $request->name,
                'admin_id' => auth()->user()->id,
                'package_type' => SubscriptionPackageTypeEnum::diet()->value,
                'message' => $request->message,
                'diet_category_id' => $request->category,
                'date' => now(),
                'status' => 0,
            ]);
            foreach ($request->meals as $meal){
                $newMeal = Meal::create([
                    'relation_type'=>'App\Models\TemplateDiet',
                    'relation_id'=>$template_diet->id,
                    'meal_time_id'=>$meal['meal_time_id'],
                    'start_at'=>MealTime::find($meal['meal_time_id'])->start_at,
                    'end_at'=>MealTime::find($meal['meal_time_id'])->end_at,
                ]);
                foreach ($meal['nutrients'] as $nutrient)
                {
                    MealNutrient::create([
                        'meal_id'=>$newMeal->id,
                        'nutrient_id'=>$nutrient['id'],
                        'quantity'=>$nutrient['quantity'],
                    ]);
                }
            }
            return response()->success(0, null, $template_diet->id, 201);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\TemplateDiet $diet
     * @return \Illuminate\Http\Response
     */
    public function show(TemplateDiet $diet)
    {
        return $this->withErrorHandling(function () use ($diet) {
            return DietShowResource::make($diet);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TemplateDiet $diet
     * @return \Illuminate\Http\Response
     */
    public function update(DietRequest $request, TemplateDiet $diet)
    {
        return $this->withErrorHandling(function () use ($request, $diet) {
            $diet->update([
                'name' => $request->name,
                'admin_id' => auth()->user()->id,
                'package_type' => SubscriptionPackageTypeEnum::diet()->value,
                'message' => $request->message,
                'diet_category_id' => $request->category,
                'status' => 0,
            ]);
            foreach ($diet->meals as $meal){
                $meal->nutrients()->detach();
            }
            $diet->meals()->delete();
            foreach ($request->meals as $meal){
                $newMeal = Meal::create([
                    'relation_type'=>'App\Models\TemplateDiet',
                    'relation_id'=>$diet->id,
                    'meal_time_id'=>$meal['meal_time_id'],
                    'start_at'=>MealTime::find($meal['meal_time_id'])->start_at,
                    'end_at'=>MealTime::find($meal['meal_time_id'])->end_at,
                ]);
                foreach ($meal['nutrients'] as $nutrient)
                {
                    MealNutrient::create([
                        'meal_id'=>$newMeal->id,
                        'nutrient_id'=>$nutrient['id'],
                        'quantity'=>$nutrient['quantity'],
                    ]);
                }
            }
            return response()->success(0, null, $diet->id, 201);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TemplateDiet $diet
     * @return \Illuminate\Http\Response
     */
    public function destroy(TemplateDiet $diet)
    {
        return $this->withErrorHandling(function () use ($diet) {
            $diet->delete();
            return response()->success(0, null, [], 201);
        });
    }
}
