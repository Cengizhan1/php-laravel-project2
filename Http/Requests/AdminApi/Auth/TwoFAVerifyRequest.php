<?php

namespace App\Http\Requests\AdminApi\Auth;

use Illuminate\Foundation\Http\FormRequest;

class TwoFAVerifyRequest extends FormRequest
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
            'firebase_token' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'firebase_token' => __('validation.api.firebase_token')
        ];
    }
}
