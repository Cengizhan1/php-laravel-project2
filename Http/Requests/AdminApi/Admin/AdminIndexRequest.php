<?php

namespace App\Http\Requests\AdminApi\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminIndexRequest extends FormRequest
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
            'sortBy'=>'nullable',
            'sortByDirection'=>'nullable',
            'search'=>'nullable',
            'role_id'=>'nullable|integer',
            'status'=>'nullable|integer'
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
