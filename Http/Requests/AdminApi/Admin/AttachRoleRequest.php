<?php

namespace App\Http\Requests\AdminApi\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AttachRoleRequest extends FormRequest
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
            'role_id'=>'required|integer|exists:roles,id',
            'admin_id'=>'required|integer|exists:admins,id',
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
