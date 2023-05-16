<?php

namespace App\Http\Requests\AdminApi\Dietician;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
{
    /**
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'relation_type'=>'required|string',
            'relation_id'=>'required|integer',
            'meals.*.name'=>'required',
            'meals.*.meal_time_id'=>'required|integer|exists:meal_times,id',
            'meals.*.nutrients.*'=>'required|integer|exists:nutrients,id',
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
        ];
    }
}
