<?php

namespace App\Http\Resources\User;

use App\Models\UserSubscriptionSession;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
            'id' => $this->id,
            'name' => $this->name,
            'subscription_category' => $this->subscription_category,
            'price' => $this->price,
            'status' => $this->status,
            'vip' => $this->vip,
            'spec_description' => json_decode($this->spec_description),
            'subscription_days' => $this->subscription_days,
            'created_at' => $this->created_at,

            'stopped_count' => $this->stopped_count,
            'stopped_limit' => $this->stopped_limit,
            'stopped_sessions' => $this->stopped_sessions,
        ];
    }
}
