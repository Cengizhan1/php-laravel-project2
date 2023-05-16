<?php

namespace App\Http\Requests\UserApi\Iyzico;

use Illuminate\Foundation\Http\FormRequest;

class PaymentCheckRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token'=> 'required',

        ];
    }
}
