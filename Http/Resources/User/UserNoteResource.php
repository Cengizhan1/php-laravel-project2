<?php

namespace App\Http\Resources\User;

use App\Http\Resources\AdminApi\Admin\AdminIndexResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserNoteResource extends JsonResource
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
            'admin' => AdminIndexResource::make($this->admin),
            'date' => get_formatted_date_time($this->date),
        ];
    }
}
