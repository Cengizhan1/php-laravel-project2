<?php

namespace App\Http\Controllers\AdminApi\Dietician;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminApi\Dietician\AddMealImageRequest;
use App\Http\Requests\AdminApi\Dietician\MealIndexRequest;
use App\Http\Requests\AdminApi\Dietician\MealRequest;
use App\Http\Requests\AdminApi\Dietician\MealStoreRequest;

use App\Http\Resources\AdminApi\Dietician\MealIndexResource;
use App\Models\Meal;
use App\Models\User;
use App\Models\MealTime;
use App\Models\TemplateDetox;
use App\Models\TemplateDiet;

class  MealController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Meal::class, 'meal');
//        $this->authorizeResource(TemplateDetox::class, 'meal');
//        $this->authorizeResource(TemplateDiet::class, 'meal');
    }

    public function index(MealIndexRequest $request)
    {
        $relatedModel = match ($request->relation_type) {
            'App\Models\TemplateDiet' => TemplateDiet::find($request->relation_id),
            'App\Models\TemplateDetox' => TemplateDetox::find($request->relation_id),
            default => null,
        };

        return MealIndexResource::collection($relatedModel->meals);
    }


    public function addMealImage(AddMealImageRequest $request)
    {
        return $this->withErrorHandling(function () use ($request) {

            $object = Meal::findOrFail($request->meal_id);
            if ($request->thumb) {
                $object->clearMediaCollection('avatar');
                $object->addMedia($request->thumb)->toMediaCollection('avatar');
            }

            return response()->success(0, null, [], 201);
        });
    }

    public function askForFoodPhotos(User $user)
    {
        return $this->withErrorHandling(function () use ($request) {
            $result = $user->update([
                'food_photos_wanted' => true,
            ]);
            return response()->success(0, null, [], 201);
        });
    }

    public function donotAskForFoodPhotos(User $user)
    {
        return $this->withErrorHandling(function () use ($request) {
            $result = $user->update([
                'food_photos_wanted' => false,
            ]);
            return response()->success(0, null, [], 201);
        });
    }
}
