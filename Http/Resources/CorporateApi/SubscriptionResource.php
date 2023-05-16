<?php

namespace App\Http\Resources\CorporateApi;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'subscription_category' => $this->subscription_category,
            'price' => $this->price,
            'status' => $this->status,
            'vip' => $this->vip,
            'vipSubscription' => $this->vipSubscription,
            'spec_description' => $this->spec_description,

            'stopped_count' => $this->stopped_count,
            'stopped_limit' => $this->stopped_limit,
            'stopped_sessions' => $this->stopped_sessions,
        ];
    }
}
