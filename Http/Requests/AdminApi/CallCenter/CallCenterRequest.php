<?php

namespace App\Http\Requests\AdminApi\CallCenter;

use Illuminate\Foundation\Http\FormRequest;

class CallCenterRequest extends FormRequest
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
            'user_id'=>'required|integer',
            'note' => 'required|string',
            'date'=>'nullable|date',
            'call_result_state'=>'nullable|integer',
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
