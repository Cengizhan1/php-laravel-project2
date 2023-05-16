<?php

namespace App\Http\Requests\AdminApi\Dietician;

use Illuminate\Foundation\Http\FormRequest;

class RecipeIndexRequest extends FormRequest
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
            'start_at'=>'nullable|date',
            'end_at'=>'nullable|date',
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
