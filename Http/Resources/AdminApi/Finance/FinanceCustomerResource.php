<?php

namespace App\Http\Resources\AdminApi\Finance;

use App\Enum\StatusEnum;
use App\Enum\SubscriptionPaymentMethodEnum;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class FinanceCustomerResource extends JsonResource
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
            'package_name' => $this->subscription_category,
            'date_diff' => get_time_diff($this->start_at),
            'payment_method' => $this->payment_method,
            'price' => $this->price,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'status' => $this->status ,
        ];
    }
}
