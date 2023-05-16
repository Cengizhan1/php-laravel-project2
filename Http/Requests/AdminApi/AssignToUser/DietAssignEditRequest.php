<?php

namespace App\Http\Requests\AdminApi\AssignToUser;

use App\Models\Meet;
use App\Models\TemplateDiet;
use Illuminate\Foundation\Http\FormRequest;

class DietAssignEditRequest extends FormRequest
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
            'template_diet_id' => [
                'required',
                'integer',
                'exists:template_diets,id',
                function ($attribute, $value, $fail) {
                    $diet = TemplateDiet::find($value);
                    if (!$diet->meals->count()) {
                        $fail('Seçtiğiniz dietin öğünleri boş olamaz');
                    }
                    foreach ($diet->meals as $meal){
                        if (!$meal->nutrients->count()) {
                            $fail($meal->id.' id li öğünün besinleri boş olamaz');
                        }
                    }
                },
            ],
            'user_id' => 'required|integer|exists:users,id',

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
