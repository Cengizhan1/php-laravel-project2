<?php

namespace App\Http\Requests\AdminApi\Dietician;

use Illuminate\Foundation\Http\FormRequest;

class NutrientRequest extends FormRequest
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
            'unit'=>'required|integer',
            'calorie'=>'required|numeric',
            'description'=>'string|nullable',
            'date'=>'nullable|date',
            'vegan'=>'required|boolean',
            'vegetarian'=>'required|boolean',
            'pregnant'=>'required|boolean',
            'suckle'=>'required|boolean',
            'blood_group'=>'nullable|boolean',
            'disease'=>'nullable|array',
            'alergies'=>'nullable|array',
            'suckle_week_information'=>'nullable|array',
            'pregnant_week_information'=>'nullable|array',
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
