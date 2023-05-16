<?php

namespace App\Http\Requests\AdminApi\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class FinanceSubscriptionStoreRequest extends FormRequest
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
            'customers' => 'required|array',
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
