<?php

namespace App\Http\Resources\AdminApi\Admin;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\AdminApi\RoleResource;

class AdminShowResource extends JsonResource
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
            'firebase_device_token' => $this->firebase_device_token,
            'status' => $this->status,
            'phone' => $this->phone,
            'email' => $this->email,
            'role' => RoleResource::make($this->role),
            'media'=>[
                'avatar'=>$this->getFirstMediaUrl('avatar', 'crop') ?: null,
            ],
            'activities' => Activity::where('causer_type', 'App\Models\Admin')->where('causer_id', $this->id)->datatable(),
        ];
    }
}
