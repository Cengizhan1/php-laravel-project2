<?php

namespace App\Http\Requests\AdminApi\Dietician;

use Illuminate\Foundation\Http\FormRequest;

class MealStoreRequest extends FormRequest
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
            'relation_type'=>'required|string',
            'relation_id'=>'required|integer',
            'meals.*.start_at' => 'required',
            'meals.*.end_at' => 'required',
            'meals.*.meal_time_id'=>'required|integer|exists:meal_times,id',
            'meals.*.nutrients.*'=>'required|integer|exists:nutrients,id',
        ];
    }
}
