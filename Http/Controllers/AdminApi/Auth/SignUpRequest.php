<?php

namespace App\Http\Requests\Front\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'email' => 'nullable|string|email:rfc,strict|max:255|unique:customers,email',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'firebase_uid' => 'required|string|max:50|unique:customers,firebase_uid',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name' => trans('user.columns.first_name'),
            'last_name' => trans('user.columns.last_name'),
            'email' => trans('user.columns.email'),
        ];
    }
}
