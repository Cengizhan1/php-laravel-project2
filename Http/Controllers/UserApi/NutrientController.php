<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nutrient;
use App\Http\Resources\AdminApi\Dietician\NutrientShowResource;

class NutrientController extends Controller
{
    public function show(Nutrient $nutrient)
    {
        return $this->withErrorHandling(function () use ($nutrient) {
            return NutrientShowResource::make($nutrient);
        });
    }
}
