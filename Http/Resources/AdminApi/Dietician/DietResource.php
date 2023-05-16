<?php

namespace App\Http\Resources\AdminApi\Dietician;

use App\Enum\SubscriptionPackageTypeEnum;
use App\Http\Resources\AdminApi\AdminResource;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class  DietResource extends JsonResource
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
            'admin'=>new AdminResource($this->admin),
            'package_type' => SubscriptionPackageTypeEnum::diet()->label,
            'date'=>get_formatted_date($this->date),
            'category'=>DietCategoryResource::make($this->category),
            'status'=>$this->status
        ];
    }
}
