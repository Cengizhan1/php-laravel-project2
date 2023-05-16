<?php

namespace App\Http\Resources\AdminApi\Dietician;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class DietCategoryResource extends JsonResource
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
        ];
    }
}
