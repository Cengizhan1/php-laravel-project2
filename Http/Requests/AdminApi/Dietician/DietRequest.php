<?php

namespace App\Http\Requests\AdminApi\Dietician;

use Illuminate\Foundation\Http\FormRequest;

class DietRequest extends FormRequest
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
            'name'=>'required',
            'message'=>'nullable',
            'category'=>'required|integer|exists:diet_categories,id',
            'meals.*.meal_time_id'=>'required|integer|exists:meal_times,id',
            'meals.*.nutrients.*.id'=>'required|integer|exists:nutrients,id',
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
