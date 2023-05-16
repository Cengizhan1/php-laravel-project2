<?php

namespace App\Http\Resources\AdminApi\Dietician;

use App\Http\Resources\AdminApi\AdminResource;
use App\Http\Resources\User\AllergyResource;
use App\Http\Resources\User\AlternativeNutrientResource;
use App\Http\Resources\User\DiseaseResource;
use App\Http\Resources\User\NutrientResource;
use App\Http\Resources\User\RecipeResource;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class NutrientShowResource extends JsonResource
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
            'quantity' =>(integer)$this->pivot?->quantity ?? 1,
            'unit' => $this->unit,
            'calorie' => $this->calorie,
            'admin'=>AdminResource::make($this->admin),
            'description' => $this->description,
            'recipe'=>RecipeIndexResource::make($this->recipe),
            'vegan' => $this->vegan,
            'vegetarian' => $this->vegetarian,
            'pregnant' => $this->pregnant,
            'suckle' => $this->suckle,
            'suckle_week_information'=>$this->suckle_week_information,
            'pregnant_week_information'=>$this->pregnant_week_information,
//            'blood_group' => $this->blood_group,
            'date'=>get_formatted_date($this->date),
            'alternative_nutrient'=>AlternativeNutrientResource::collection($this->alternative_nutrients()),
            'media' => [
                'thumb' =>  $this->getFirstMediaUrl('thumb', 'crop'),
            ],
            'allergies' => AllergyResource::collection($this->alergies_nutrients),
            'diseases' => DiseaseResource::collection($this->disease)

        ];
    }
}
