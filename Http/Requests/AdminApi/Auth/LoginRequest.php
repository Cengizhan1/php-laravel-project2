<?php

namespace App\Http\Requests\AdminApi\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'email' => __('validation.api.firebase_token'),
            'password' => __('validation.api.firebase_token'),
        ];
    }
}
