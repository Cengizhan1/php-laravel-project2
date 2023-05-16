<?php

namespace App\Http\Resources\User;

use App\Enum\SubscriptionSessionTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionCommentResource extends JsonResource
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
            'user_subscription_id' => $this->user_subscription_id,
            'time' => get_time_diff($this->userSubscription->start_at),
            'package_type' => $this->userSubscription->subscription_category,
            'dietician' => $this->dietician,
            'call_center' => $this->call_center,
            'diet' => $this->diet,
            'general' => $this->general,
            'body' => $this->body,
        ];
    }
}
