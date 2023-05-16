<?php

namespace App\Http\Resources\User;

use App\Enum\SubscriptionPackageTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class DietResource extends JsonResource
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
            'name' => $this->name,
            'admin_id' => $this->admin_id,
            'package_type' => SubscriptionPackageTypeEnum::diet()->label,
            'diet_category_id' => new DietCategoryResource($this->category),
            'subscription' => new ActiveSubscriptionResource($this->subscription),
            'user_id' => $this->user_id,
            'message' => $this->message,
            'status' => $this->status,
            'isAddedBeforeAfter' => $this->user?->isAddedBeforeAfter,
            'meals'=>MealResource::collection($this->meals)
        ];
    }
}
