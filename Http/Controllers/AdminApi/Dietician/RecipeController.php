<?php

namespace App\Http\Controllers\AdminApi\Dietician;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Dietician\RecipeIndexRequest;
use App\Http\Requests\AdminApi\Dietician\RecipeRequest;
use App\Http\Resources\AdminApi\Dietician\RecipeIndexResource;
use App\Http\Resources\AdminApi\Dietician\RecipeShowResource;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Recipe::class);
    }

    public function index(RecipeIndexRequest $request)
    {
        return RecipeIndexResource::collection(
            get_filtered_data(Recipe::query(),$request)->datatable()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecipeRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $recipe = Recipe::create([
                'name' => $request->name,
                'admin_id' => auth()->user()->id,
                'description' => $request->description,
                'date' => $request->date ?? now(),
            ]);
            $recipe->nutrient()->attach($request->nutrients);
            $recipe->save();
            return response()->success(0, null, $recipe->id, 201);
        });
    }


    public function show(Recipe $recipe)
    {
        return $this->withErrorHandling(function () use ($recipe) {
                return RecipeShowResource::make($recipe);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        return $this->withErrorHandling(function () use ($request, $recipe) {
            $recipe->update([
                'name' => $request->name,
                'admin_id' => $request->admin_id,
                'description' => $request->description,
                'date' => $request->date ?? now(),
            ]);
            $recipe->nutrient()->detach();
            $recipe->nutrient()->attach($request->nutrients);
            $recipe->save();
            return response()->success(0, null, $recipe->id, 201);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        return $this->withErrorHandling(function () use ($recipe) {
            $recipe->delete();
            return response()->success(0, null, [], 201);
        });
    }
}
