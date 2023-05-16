<?php

namespace App\Http\Resources\AdminApi\Finance;

use App\Enum\StatusEnum;
use App\Enum\SubscriptionPaymentMethodEnum;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class FinancePaymentResource extends JsonResource
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
            'amount' => $this->amount,
            'date' => get_formatted_date($this->date),
        ];
    }
}
