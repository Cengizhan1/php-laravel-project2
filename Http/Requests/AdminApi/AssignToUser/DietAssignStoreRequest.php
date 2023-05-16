<?php

namespace App\Http\Requests\AdminApi\AssignToUser;

use Illuminate\Foundation\Http\FormRequest;

class DietAssignStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'package_type' => 'required|integer|min:0|max:1',
            'diet_category_id' => 'required|integer',
            'user_id' => 'required|integer',
            'message' => 'required|string',
            'status' => 'required|integer',
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
