<?php

namespace App\Http\Resources\AdminApi;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class  CustomerIndexResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'firebase_uid' => $this->firebase_uid,
            'photo_share_permission' => $this->photo_share_permission,
            'package_name' => $this->user?->activeSubscription()?->subscription_category,
            'date_diff' => get_time_diff($this->user?->activeSubscription()?->start_at),
            'media' => [
                'avatar' => $this->getFirstMediaUrl('avatar', 'crop') ?: null,
            ]
        ];
    }
}
