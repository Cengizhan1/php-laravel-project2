<?php

namespace App\Http\Requests\UserApi\User;

use App\Models\Meet;
use Illuminate\Foundation\Http\FormRequest;

class MeetCommentStoreRequest extends FormRequest
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
            'meet_id' => ['required', 'integer',
                function ($attribute, $value, $fail) {
                    if (!Meet::where('id', '=', $this->meet_id)->exists()) {
                        $fail('Comment with this id does not exist');
                    }
                }],
            'stars' => 'required|numeric',
            'body' => 'required|string|max:500',
        ];
    }
}
