<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMeasurementResource extends JsonResource
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
            'date' => $this->date,
            'waist_circumference' => $this->waist_circumference,
            'belly_circumference' => $this->belly_circumference,
            'upper_arm_circumference' => $this->upper_arm_circumference,
            'upper_leg_circumference' => $this->upper_leg_circumference,
            'hip_circumference' => $this->hip_circumference,
            'chest_circumference' => $this->chest_circumference,
            'neck_circumference' => $this->neck_circumference,
            'diet_compatibility_id' => $this->diet_compatibility_id,
            'weekly_exercise_count_id' => $this->weekly_exercise_count_id,
            'message' => $this->message,
            'weight' => $this->weight,
            'fat' => $this->fat,
            'extra_cases' => $this->extra_cases,
            'diet_compliance_status' => $this->diet_compliance_status,
            'weekly_exercise_status' => $this->weekly_exercise_status,
            'media'=>[
                'avatar'=>$this->getFirstMediaUrl('user_measurements', 'crop') ?: null,
            ]
        ];
    }
}
