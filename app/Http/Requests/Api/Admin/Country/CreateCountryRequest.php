<?php

namespace App\Http\Requests\Api\Admin\Country;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CreateCountryRequest",
 *     type="object",
 *     required={
 *         "name_ar", "name_en", "code"
 *     },
 *     @OA\Property(property="name_ar", type="string", maxLength=255, example="صربيا"),
 *     @OA\Property(property="name_en", type="string", maxLength=255, example="Serbia"),
 *     @OA\Property(property="code", type="string", maxLength=10, example="ad"),
 * )
 */
class CreateCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return T_ATTRIBUTE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'code' => 'required|string|max:10',
        ];
    }
}
