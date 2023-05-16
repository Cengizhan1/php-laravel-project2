<?php

namespace App\Http\Resources\AdminApi\Dietician;

use App\Http\Resources\AdminApi\AdminResource;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class RecipeIndexResource extends JsonResource
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
            'date'=>get_formatted_date($this->date),
            'message' => $this->message,

        ];
    }
}
