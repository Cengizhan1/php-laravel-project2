<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BeforeAfterNotCollapseResource extends JsonResource
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
            'type'=> $this->order==0 ? 'before':'after',
            'status'=> 0,
            'media'=>[
                'original'=>$this->getFirstMediaUrl('original', 'crop') ?: null,
            ],
            'date' => $this->created_at,
        ];
    }
}
