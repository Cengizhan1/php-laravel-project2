<?php

namespace App\Http\Resources\User;

use App\Enum\StatusEnum;
use App\Enum\SubscriptionPaymentMethodEnum;
use App\Enum\SubscriptionSessionTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
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
            'user_id' => UserResource::make($this->user),
            'time' => get_time_diff($this->start_at).' '.SubscriptionSessionTypeEnum::from($this->subscription_category)->label,
            'package_type' => SubscriptionSessionTypeEnum::from($this->subscription_category)->value,
            'payment_method' => SubscriptionPaymentMethodEnum::from($this->payment_method)->value,
            'price' => $this->price,
            'start_at' => get_formatted_date($this->start_at),
            'status' => StatusEnum::from($this->status)->label,
            'remaining_time' => Carbon::now()-> diffInDays($this->end_at, false),
            'created_at' => $this->created_at,
        ];
    }
}
