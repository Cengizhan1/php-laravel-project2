<?php

namespace App\Http\Requests\AdminApi\Dietician;

use Illuminate\Foundation\Http\FormRequest;

class MealIndexRequest extends FormRequest
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
            'relation_type'=>'required|string',
            'relation_id'=>'required|integer',
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
