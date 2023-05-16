<?php

namespace App\Http\Requests\AdminApi\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UserMeasurementDateRequest extends FormRequest
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
            'date' => 'required|date',
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'rows' => __('validation.api.rows'),
            'password' => __('validation.api.firebase_token'),
        ];
    }
}
