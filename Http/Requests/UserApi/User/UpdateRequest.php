<?php

namespace App\Http\Requests\UserApi\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class UpdateRequest extends FormRequest
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
            'first_name' => 'required|string|min:3|max:255',
            'thumb' => 'nullable',
            'last_name' => 'required|string|min:3|max:255',
            'birth_date'=>'date|nullable',
            'email' => 'nullable|string|email:rfc,strict|max:255',
            'gender'=>'required|integer',
            'job_id'=>'required|integer|exists:jobs,id',
            'weight'=>'required|integer',
            'target_weight'=>'required|integer',
            'destination_id'=>'required|integer',
            'operation'=>'required|boolean',
            'medicine'=>'required|boolean',
            'operation_description'=>'nullable|string',
            'medicine_description'=>'nullable|string',
            'eating_habit_id'=>'required|integer|exists:eating_habits,id',
            'physical_activity_id'=>'required|integer|exists:physical_activities,id',
            'daily_caffeine_id'=>'required|integer|exists:daily_caffeines,id',
            'daily_water_id'=>'required|integer|exists:daily_waters,id',
            'sleep_pattern_id'=>'required|integer|exists:sleep_patterns,id',
            'vegan'=>'required|boolean',
            'vegetarian'=>'required|boolean',
            'pregnant'=>'required|boolean',
            'pregnant_week_count'=>'nullable|integer',
            'suckle'=>'required|boolean',
            'suckle_week_count'=>'nullable|integer',
            'blood_group'=>'required|integer',
            'special_state'=>'nullable|string',
            'health_problem' => 'nullable|integer|exists:health_problems,id',
            'allergies' => 'nullable',
            'diseases' => 'nullable',
        ];
    }


    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new JsonResponse([
            'message' => $validator->errors()->first(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name' => trans('user.columns.first_name'),
            'last_name' => trans('user.columns.last_name'),
            'email' => trans('user.columns.email'),
        ];
    }
}
