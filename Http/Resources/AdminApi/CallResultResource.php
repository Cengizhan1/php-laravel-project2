<?php

namespace App\Http\Resources\AdminApi;

use App\Http\Resources\AdminApi\Admin\AdminIndexResource;
use Carbon\Carbon;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class CallResultResource extends JsonResource
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
            'first_name' => $this->user?->first_name,
            'last_name' => $this->user?->last_name,
            'phone' => $this->user?->phone,
            'created_at' => $this->created_at,
            'date' => get_formatted_date_time($this->date),
            'call_result_state' => $this->call_result_state,
            'note' => $this->note,
            'admin'=>AdminIndexResource::make($this->admin),

        ];
    }
}
