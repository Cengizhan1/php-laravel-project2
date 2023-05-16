<?php

namespace App\Http\Requests\AdminApi\Home;

use Illuminate\Foundation\Http\FormRequest;

class DateFilterRequest extends FormRequest
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
            'date_by' =>'required|integer'
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
