<?php

namespace App\Http\Requests\AdminApi\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class FinanceIndexRequest extends FormRequest
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
            'search' => 'nullable|string',
            'country_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'package_type' => 'nullable|integer',
            'job_id' => 'nullable|integer',
            'age' => 'nullable|integer',
            'payment_method' => 'nullable|integer',
            'recurring_purchases' => 'nullable|boolean',
            'is_first_package' => 'nullable|integer',
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
