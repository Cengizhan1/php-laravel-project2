<?php

namespace App\Http\Resources\User;

use App\Http\Resources\AdminApi\AdminResource;
use App\Http\Resources\AdminApi\Dietician\RecipeIndexResource;
use App\Models\Nutrient;
use Illuminate\Http\Resources\Json\JsonResource;

class  AlternativeNutrientResource extends JsonResource
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
            'unit' => $this->unit,
            'calorie' => $this->calorie,
            'admin'=>AdminResource::make($this->admin),
            'description' => $this->description,
            'recipe'=>RecipeIndexResource::make($this->recipe),
            'vegan' => $this->vegan,
            'vegetarian' => $this->vegetarian,
            'pregnant' => $this->pregnant,
            'suckle' => $this->suckle,
            'date'=>get_formatted_date($this->date),
            'media' => [
                'thumb' =>  $this->getFirstMediaUrl('thumb', 'crop'),
            ],
            'allergies' => $this->alergies_nutrients,
            'diseases' => $this->disease,
        ];
    }
}
