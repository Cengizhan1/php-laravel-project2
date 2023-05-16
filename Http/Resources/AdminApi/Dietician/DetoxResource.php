<?php

namespace App\Http\Resources\AdminApi\Dietician;

use App\Enum\SubscriptionPackageTypeEnum;
use App\Http\Resources\AdminApi\AdminResource;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class DetoxResource extends JsonResource
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
            'name' => $this->name,
            'admin'=>AdminResource::make($this->admin),
            'package_type' => SubscriptionPackageTypeEnum::detox()->value,
            'date'=>$this->date,
            'category'=>DetoxCategoryResource::make($this->category),
            'status'=>$this->status
        ];
    }
}
