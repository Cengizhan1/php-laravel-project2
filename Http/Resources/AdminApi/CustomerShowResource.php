<?php

namespace App\Http\Resources\AdminApi;

use App\Http\Resources\User\UserNoteResource;
use ObiPlus\ObiPlus\Http\Resources\Json\JsonResource;

use App\Http\Resources\User\JobResource;
use App\Http\Resources\User\PhysicalActivityResource;
use App\Http\Resources\User\EatingHabitResource;
use App\Http\Resources\User\DailyCaffeineResource;
use App\Http\Resources\User\DailyWaterResource;
use App\Http\Resources\User\SleepPatternResource;
use App\Http\Resources\User\DiseaseResource;
use App\Http\Resources\User\AllergyResource;

use App\Models\Job;
use App\Models\PhysicalActivity;
use App\Models\EatingHabit;
use App\Models\DailyCaffeine;
use App\Models\DailyWater;
use App\Models\SleepPattern;

class CustomerShowResource extends JsonResource
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
            'media' => [
                'avatar' => $this->getFirstMediaUrl('avatar', 'crop') ?: null,
            ],
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'job' => JobResource::make($this->information()->first()->job),
            'gender' => $this->gender,
            'current_weight' => $this->information()->first()->weight,
            'target_weight' => $this->information()->first()->target_weight,
            'aim' => $this->information()->first()->destination_id,
            'health_problems' => $this->health_problems,
            'diseases' => DiseaseResource::collection($this->diseases),
            'allergies' => AllergyResource::collection($this->allergies),
            'blood_group' => $this->information()->first()->blood_group,
            'physical_activity' => PhysicalActivityResource::make($this->information()->first()->physicalActivity),
            'eating_habit' => EatingHabitResource::make($this->information()->first()->eatingHabit),
            'daily_caffeine' => DailyCaffeineResource::make($this->information()->first()->dailyCaffeine),
            'daily_water' => DailyWaterResource::make($this->information()->first()->dailyWater),
            'sleep_pattern' => SleepPatternResource::make($this->information()->first()->sleepPattern),
            'operation' => $this->information()->first()->operation,
            'operation_description' => $this->information()->first()->operation_description,
            'medicine' => $this->information()->first()->medicine,
            'medicine_description' => $this->information()->first()->medicine_description,
            'pregnant' => $this->information()->first()->pregnant,
            'breast_feeding' => $this->information()->first()->suckle,
            'pregnant_week_count' => $this->information()->first()->pregnant_week_count,
            'suckle_week_count' => $this->information()->first()->suckle_week_count,
            'vegan' => $this->information()->first()->vegan,
            'vegetarian' => $this->information()->first()->vegetarian,
            'special_state' => $this->information()->first()->special_state,
            'active_package' => $this->activeSubscription(),
        ];
    }
}
