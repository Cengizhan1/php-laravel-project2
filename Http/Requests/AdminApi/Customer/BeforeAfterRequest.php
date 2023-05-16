<?php

namespace App\Http\Requests\AdminApi\Customer;

use Illuminate\Foundation\Http\FormRequest;

class BeforeAfterRequest extends FormRequest
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
            'package_id' => 'nullable|integer|exists:user_subscriptions,id',
            'week' => 'nullable|integer',
        ];
    }
}
