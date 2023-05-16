<?php

namespace App\Http\Requests\AdminApi\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'user_id' => 'nullable|integer|exists:users,id',
            'comment_type' => 'nullable|integer',
            'comment_rate' => 'nullable|integer',
        ];
    }
}
