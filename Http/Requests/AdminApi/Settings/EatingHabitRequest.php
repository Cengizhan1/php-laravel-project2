<?php

namespace App\Http\Requests\AdminApi\Settings;

use Illuminate\Foundation\Http\FormRequest;

class EatingHabitRequest extends FormRequest
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
            'items.*.id' => 'required_if:items.*.operation_type,==,1,2',
            'items.*.name' => 'required_if:items.*.operation_type,==,0',
            'items.*.operation_type' => 'integer'
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
