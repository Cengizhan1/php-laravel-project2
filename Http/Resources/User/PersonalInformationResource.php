<?php

namespace App\Http\Resources\User;

use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

class PersonalInformationResource extends JsonResource
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
            'job'=>JobResource::make($this->job),
            'weight'=>$this->weight,
            'target_weight'=>$this->target_weight,
            'destination'=>$this->destination_id,
            'operation'=>$this->operation,
            'medicine'=>$this->medicine,
            'operation_description'=>$this->operation_description,
            'medicine_description'=>$this->medicine_description,
            'eating_habit'=>new EatingHabitResource($this->eatingHabit),
            'physical_activity'=>new PhysicalActivityResource($this->physicalActivity),
            'daily_caffeine'=>new DailyCaffeineResource($this->dailyCaffeine),
            'daily_water'=>new DailyWaterResource($this->dailyWater),
            'sleep_pattern'=>new SleepPatternResource($this->sleepPattern),
            'vegan'=>$this->vegan,
            'vegetarian'=>$this->vegetarian,
            'pregnant'=>$this->pregnant,
            'pregnant_week_count'=>$this->pregnant_week_count,
            'suckle'=>$this->suckle,
            'suckle_week_count'=>$this->suckle_week_count,
            'blood_group'=>$this->blood_group,
            'special_state'=>$this->special_state,
        ];
    }
}
