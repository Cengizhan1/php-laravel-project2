<?php

namespace App\Http\Resources\User;

use App\Http\Resources\AdminApi\Dietician\NutrientShowResource;
use App\Http\Resources\AdminApi\Settings\AdminMealTimeResource;
use App\Models\Nutrient;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
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
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'mealTime' => AdminMealTimeResource::make($this->mealTime),
            'message' => $this->message,
            'calorie'=>$this->nutrients()->sum('calorie'),
            'nutrients'=> NutrientShowResource::collection($this->nutrients()?->with('disease','alergies_nutrients')
                ->withPivot('quantity')->get()),
            'media' => [
                'meal_image_user' => $this->getFirstMediaUrl('meal_image_user', 'crop') ?: null,
                'meal_image_admin' => $this->getFirstMediaUrl('meal_image_admin', 'crop') ?: null,
            ]
        ];
    }
}
