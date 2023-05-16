<?php

namespace App\Http\Resources\AdminApi\Dietician;

use App\Enum\SubscriptionPackageTypeEnum;
use App\Http\Resources\AdminApi\AdminResource;
use App\Http\Resources\User\AlternativeNutrientResource;
use App\Http\Resources\User\MealResource;
use App\Http\Resources\User\NutrientResource;
use App\Http\Resources\User\RecipeResource;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class DietShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'admin'=>AdminResource::make($this->admin),
            'package_type' => SubscriptionPackageTypeEnum::diet()->label,
            'date'=>$this->date,
            'category'=>DietCategoryResource::make($this->category),
            'status'=>$this->status,
            'message'=>$this->message,
            'meals'=>MealResource::collection($this->meals)
        ];
    }
}
