<?php

namespace App\Http\Resources\AdminApi\Home;

use App\Models\UserSubscription;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class HomeSaleResource extends JsonResource
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
            'total' => $this->sum('price'),
            'detox' => $this->where('subscription_category', 0)->sum('price'),
            'onlineDiet' => $this->where('subscription_category', 1)->sum('price'),
            'faceToFace' => $this->where('subscription_category', 2)->sum('price'),
        ];
    }
}
