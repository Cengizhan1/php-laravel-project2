<?php

namespace App\Http\Requests\AdminApi\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class ChartRequest extends FormRequest
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
            'type'=>'required|integer',
            'date_by'=>'required|integer',
        ];
    }
}
