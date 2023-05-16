<?php

namespace App\Http\Requests\AdminApi\Calendar;

use Illuminate\Foundation\Http\FormRequest;

class MeetRequest extends FormRequest
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
            'meets' => 'required',
            'start_at' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if ($value < now()) {
                        $fail('Başlangıç tarihi geçmiş bir tarih olamaz');
                    }
                    if ($value >= $this->end_at) {
                        $fail('Başlangıç tarihi bitiş tarihinden büyük yada aynı olamaz');
                    }
                },
            ],
            'end_at' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if ($value <= $this->start_at) {
                        $fail('Bitiş tarihi başlangıç tarihinden küçük yada aynı olamaz');
                    }
                },
            ],
            'meets.*.user_id' => 'required|integer|exists:users,id',
            'meets.*.meet_type' => 'required|integer',
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
