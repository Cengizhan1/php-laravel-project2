<?php

namespace App\Http\Resources\AdminApi\Customer;

use App\Models\UserMeasurement;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class  ReportCardDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $measuremnt = UserMeasurement::where('user_subscription_session_id',$this->id)->first();
        return [
            'id' => $this->id,
            'weight' => $measuremnt?->weight,
            'fat' => $measuremnt?->fat,
        ];
    }
}
