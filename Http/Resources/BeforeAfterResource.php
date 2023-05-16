<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BeforeAfterResource extends JsonResource
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
            'media'=>[
                'before_after'=>$this->getFirstMediaUrl('before_after', 'crop') ?: null,
            ],
            'date' => $this->created_at,
        ];
    }
}
