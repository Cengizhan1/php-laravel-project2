<?php

namespace App\Http\Resources\AdminApi\Home;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class HomeWaitingActionsResource extends JsonResource
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
            'id' => $this->user->id,
            'first_name' => $this->user?->first_name,
            'last_name' => $this->user?->last_name,
            'package_name' => $this->name,
            'date_diff' => get_time_diff($this->user?->activeSubscription()?->start_at),
            'date' => get_formatted_date($this->start_at),
            'media' => [
                'avatar' => $this->user?->getFirstMediaUrl('avatar', 'crop') ?: null,
            ],
        ];
    }
}
