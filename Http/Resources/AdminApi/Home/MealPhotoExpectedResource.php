<?php

namespace App\Http\Resources\AdminApi\Home;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class MealPhotoExpectedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->mealable?->user?->id,
            'first_name' => $this->mealable?->user?->first_name,
            'last_name' => $this->mealable?->user?->last_name,
            'date' => $this->created_at,
            'package_name' => $this->user?->activeSubscription()?->name,
            'date_diff' => get_time_diff($this->user?->activeSubscription()?->start_at),
            'avatar' => [
                'avatar' => $this->user?->getFirstMediaUrl('avatar', 'crop') ?: null,
            ],
        ];
    }
}
