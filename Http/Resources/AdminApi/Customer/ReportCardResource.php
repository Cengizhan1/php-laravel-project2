<?php

namespace App\Http\Resources\AdminApi\Customer;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class  ReportCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'sessions'=>ReportCardDetailResource::collection($this->sessions)
        ];
    }
}
