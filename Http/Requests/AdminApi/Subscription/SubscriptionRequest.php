<?php

namespace App\Http\Requests\AdminApi\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
            'name'=>'required|string',
            'subscription_category'=>'required|integer',
            'price'=>'required|integer',
            'status'=>'required|integer',
            'vip'=>'nullable|boolean',
            'vip_subscription_id'=>[
                'integer',
                'required_if:vip,==,1'
            ],
            'sessions'=>'required|array',
            'spec_description'=>'nullable',
            'subscription_days'=>'nullable|array',

            'stopped_count' => 'nullable|integer',
            'stopped_limit' => 'nullable|integer',
            'stopped_sessions' => 'nullable|array',
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
