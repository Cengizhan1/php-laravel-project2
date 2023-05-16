<?php

namespace App\Http\Requests\AdminApi\Settings;

use Illuminate\Foundation\Http\FormRequest;

class ClinicRequest extends FormRequest
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
           "items.*.location"=>"required|string",
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'items.*.location' => 'Konum',
        ];
    }
}
