<?php

namespace App\Http\Resources\AdminApi\Settings;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class ActivityIndexResource extends JsonResource
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
            'calorie' => $this->calorie,
            'weight_settings' => $this->weight_settings
        ];
    }
}
