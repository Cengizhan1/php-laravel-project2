<?php

namespace App\Http\Requests\AdminApi\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'amount' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if ($value > $this->user?->activeSubscription()?->remainingPrice) {
                        $fail('Kalan ödemeden fazla ödeme yapamazsınız');
                    }
                },
                ],
            'date' => 'nullable|date',
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
