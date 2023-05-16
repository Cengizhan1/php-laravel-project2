<?php

namespace App\Http\Resources\User\Calendar;

use App\Enum\SubscriptionSessionTypeEnum;
use App\Http\Resources\AdminApi\AdminResource;
use App\Http\Resources\AdminApi\Dietician\DetoxCategoryResource;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class UserMeetResource extends JsonResource
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
            'id'=>$this->id,
            'type_name' => SubscriptionSessionTypeEnum::from($this->type_id)->label,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
        ];
    }
}
