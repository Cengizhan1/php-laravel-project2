<?php

namespace App\Http\Resources\AdminApi\Admin;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;
use Spatie\Activitylog\Models\Activity;

class AdminIndexResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'status' => $this->status,
            'phone' => $this->phone,
            'email' => $this->email,
            'role' => $this->role->name,
            'can'=>$this->role?->modules,
            'media'=>[
                'avatar'=>$this->getFirstMediaUrl('avatar', 'crop') ?: null,
            ],
        ];
    }
}