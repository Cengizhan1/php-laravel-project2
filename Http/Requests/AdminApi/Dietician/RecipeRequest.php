<?php

namespace App\Http\Requests\AdminApi\Dietician;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
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
            'description'=>'required',
            'date'=>'nullable|date',
            'nutrients'=>'required|array'
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
