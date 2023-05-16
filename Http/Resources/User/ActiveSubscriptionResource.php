<?php

namespace App\Http\Resources\User;

use App\Models\UserSubscriptionSession;
use Illuminate\Http\Resources\Json\JsonResource;

class ActiveSubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $start = now();
        $end = $this->start_at;
        $dietDAy = $start->diffInDays($end);

        $start =  now();
        $end = $this->end_at;
        $totalDietDay = $start->diffInDays($end)+$dietDAy;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subscription_category' => $this->subscription_category,
            'price' => $this->price,
            'status' => $this->status,
            'vip' => $this->vip,
            'spec_description' => $this->spec_description,
            'subscription_days' => $this->subscription_days,
            'diet_day' => $dietDAy,
            'totalDietDay' => $totalDietDay,
            'start_at' => get_formatted_date($this->start_at),
            'end_at' => get_formatted_date($this->end_at),
        ];
    }
}
