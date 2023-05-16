<?php

namespace App\Http\Requests\AdminApi\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'email' => 'nullable|string|email:rfc,strict|max:255|unique:admins,email,'.$this->user('admin')->id,
            'password'=>'nullable|string',
            'phone'=>'nullable|string|unique:admins,phone',
            'role_id'=>'required|integer|exists:roles,id',
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
