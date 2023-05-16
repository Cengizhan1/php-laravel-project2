<?php

namespace App\Http\Requests\AdminApi\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
            'spec_description'=>'nullable',
            'subscription_days'=>'nullable|array',
            
            'stopped_count' => 'nullable|integer',
            'stopped_limit' => 'nullable|integer',
            'stopped_sessions' => 'nullable|array',
        ];
    }
}
