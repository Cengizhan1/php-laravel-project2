<?php

namespace App\Http\Resources\AdminApi;

use Illuminate\Http\Resources\Json\JsonResource;

class CallCenterNoteResource extends JsonResource
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
            'call_result_state'=>$this->call_result_state,
            'note' => $this->note,
            'date' => get_formatted_date($this->date),
        ];
    }
}
