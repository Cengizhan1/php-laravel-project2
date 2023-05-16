<?php

namespace App\Http\Requests\AdminApi\Customer;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'rows' => 'nullable|numeric',
            'sortBy' => 'nullable|string',
            'search' => 'nullable|string',
            'country_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'package_type' => 'nullable|integer',
            'is_no_active_package' => 'nullable|boolean',
            'is_waiting_action' => 'nullable|boolean',
            'status' => 'nullable|integer',
            'is_new_customer' => 'nullable|integer',
            'is_regular_customers' => 'nullable|integer',
            'is_those_who_no_not_continue' => 'nullable|integer',
            'is_requesting_calorie_information' => 'nullable|integer',
            'is_requesting_diet_list_comparison' => 'nullable|integer',
            'call_result_status' => 'nullable|integer',
            'not_contacted' => 'nullable|integer',
            'active_package' => 'nullable|boolean',
            'photo_share_permission' => 'nullable|boolean',
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
