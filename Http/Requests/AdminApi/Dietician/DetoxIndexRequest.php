<?php

namespace App\Http\Requests\AdminApi\Dietician;

use Illuminate\Foundation\Http\FormRequest;

class DetoxIndexRequest extends FormRequest
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
            'admin_id'=>'nullable',
            'date'=>'nullable|date',
            'category'=>'nullable|integer',
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
