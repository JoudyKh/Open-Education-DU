<?php

namespace App\Http\Requests\Api\Admin\Province;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateProvinceRequest",
 *     type="object",
 *     @OA\Property(property="en_name", type="string", example="exampleValueEN"),
 *     @OA\Property(property="ar_name", type="string", example="exampleValueAR"),
 *     @OA\Property(property="key", type="string", example="09"),
 * )
 */
class UpdateProvinceRequest extends FormRequest
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
            'ar_name' => 'nullable|string|max:255',
            'en_name' => 'nullable|string|max:255',
            'key' => 'nullable|string|max:255',
        ];
    }
}
