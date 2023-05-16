<?php

namespace App\Http\Resources\AdminApi\Dietician;

use App\Http\Resources\AdminApi\AdminResource;
use App\Http\Resources\User\NutrientResource;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class MealIndexResource extends JsonResource
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
//            'relation_type' => $this->relation_type,
//            'relation_id' => $this->relation_id,
            'start_at'=>$this->start_at,
            'end_at'=>$this->end_at,
            'meal_time_id' => $this->meal_time_id,
            'message' => $this->message,
            'calorie'=>$this->nutrients()->sum('calorie'),
            'nutrients'=> NutrientResource::collection($this->nutrients()->get()),
            'media' => [
                'meal_image_user' => $this->getFirstMediaUrl('meal_image_user', 'crop') ?: null,
                'meal_image_admin' => $this->getFirstMediaUrl('meal_image_admin', 'crop') ?: null,
            ]
        ];
    }
}
