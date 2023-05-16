<?php

namespace App\Http\Resources\AdminApi;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminApi\AdminResource;

class QuickMessageResource extends JsonResource
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
            'admin_id' => AdminResource::make($this->admin),
            'title' => $this->title,
            'body' => $this->body,
            'date' => $this->date,
        ];
    }
}
