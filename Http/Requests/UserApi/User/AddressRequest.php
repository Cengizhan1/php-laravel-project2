<?php

namespace App\Http\Requests\UserApi\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class AddressRequest extends FormRequest
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
            'name' => 'required|string',
            'city_id' => 'required|integer',
            'address' =>  'required|string',
            'is_default' =>  'nullable|boolean',
        ];
    }
}
