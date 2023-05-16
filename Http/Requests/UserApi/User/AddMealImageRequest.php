<?php

namespace App\Http\Requests\UserApi\User;

use Illuminate\Foundation\Http\FormRequest;

class AddMealImageRequest extends FormRequest
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
            'meal_id' => 'required|integer',
            'thumb' => 'file',
            'alternative_nutrient_id' => 'integer',
            'nutrient_id' => 'integer',
        ];
    }
}
