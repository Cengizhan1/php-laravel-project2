<?php

namespace App\Http\Resources\AdminApi\Calendar;

use App\Enum\MeetStatusEnum;
use App\Enum\SubscriptionSessionTypeEnum;
use App\Http\Resources\AdminApi\AdminResource;
use App\Http\Resources\AdminApi\Dietician\DetoxCategoryResource;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class MeetResource extends JsonResource
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
            'user_id' => $this->user_id,
            'type_id' => $this->type_id,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'status' => MeetStatusEnum::from($this->status)->value,
            'status_label' => MeetStatusEnum::from($this->status)->label,
            'join_code' => $this->join_code,
        ];
    }
}
