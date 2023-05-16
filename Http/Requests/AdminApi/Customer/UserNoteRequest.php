<?php

namespace App\Http\Requests\AdminApi\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UserNoteRequest extends FormRequest
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
            'note_type' => 'required|integer',
        ];
    }
}
