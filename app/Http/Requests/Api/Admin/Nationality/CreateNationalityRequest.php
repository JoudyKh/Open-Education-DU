<?php

namespace App\Http\Requests\Api\Admin\Nationality;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CreateNationalityRequest",
 *     type="object",
 *     required={
 *         "ar_name", "en_name"
 *     },
 *     @OA\Property(property="ar_name", type="string", example="ar"),
 *     @OA\Property(property="en_name", type="string", example="en"),
 * )
 */
class CreateNationalityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ar_name' => 'required|string|max:255',
            'en_name' => 'required|string|max:255',
        ];
    }
}
