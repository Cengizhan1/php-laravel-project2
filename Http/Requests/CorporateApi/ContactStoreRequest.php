<?php

namespace App\Http\Requests\CorporateApi;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'subject' => 'required|string|min:3|max:255',
            'email' => 'string|email:rfc,strict|max:255',
            'phone' => 'string|max:20',
            'message' => 'string|max:255',
        ];
    }
}
