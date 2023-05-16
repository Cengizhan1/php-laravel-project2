<?php

namespace App\Http\Resources\User;

use App\Models\Nutrient;
use Illuminate\Http\Resources\Json\JsonResource;

class NutrientResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'unit' => $this->unit,
            'calorie' => $this->calorie,
            'recipe'=>RecipeResource::make($this->recipe),
            'alternative_nutrients'=>AlternativeNutrientResource::collection($this->alternative_nutrients())

        ];
    }
}
