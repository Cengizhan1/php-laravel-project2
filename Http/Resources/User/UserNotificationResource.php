<?php

namespace App\Http\Resources\User;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class UserNotificationResource extends JsonResource
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
            'sms_notification' => $this->sms_notification,
            'email_notification' => $this->email_notification,
            'app_notification' => $this->app_notification,
        ];
    }
}
