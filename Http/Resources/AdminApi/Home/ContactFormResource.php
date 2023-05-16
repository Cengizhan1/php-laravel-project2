<?php

namespace App\Http\Resources\AdminApi\Home;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class ContactFormResource extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'seen' => $this->seen,
            'created_at' => get_formatted_date($this->created_at),
        ];
    }
}
