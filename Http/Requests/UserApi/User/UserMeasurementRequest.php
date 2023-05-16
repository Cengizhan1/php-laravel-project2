<?php

namespace App\Http\Requests\UserApi\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class UserMeasurementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'nullable|date',
            'waist_circumference' => 'required|integer',
            'belly_circumference' => 'required|integer',
            'upper_arm_circumference' => 'required|integer',
            'upper_leg_circumference' => 'required|integer',
            'hip_circumference' => 'required|integer',
            'chest_circumference' => 'required|integer',
            'neck_circumference' => 'required|integer',
            'weekly_exercise_count_id' => 'required|integer',
            'weight' => 'required|integer',
            'fat' => 'integer',
            'message' => 'nullable|string',
            'thumb' => 'nullable',
            'extra_cases' => 'required|integer',
            'diet_compliance_status' => 'required|integer',
            'weekly_exercise_status' => 'required|integer',
        ];
    }

}
