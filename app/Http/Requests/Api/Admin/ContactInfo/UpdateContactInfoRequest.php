<?php

namespace App\Http\Requests\Api\Admin\ContactInfo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateContactInfoRequest",
 *     type="object",
 *     @OA\Property(property="phone_number", type="integer", example="09778"),
 *     @OA\Property(property="landline_number", type="integer", example="5332"),
 *     @OA\Property(property="city_of_residence_id", type="integer", example="1"),
 *     @OA\Property(property="email", type="string", example="example@example.com"),
 *     @OA\Property(property="permanent_address", type="", example="text"),
 *     @OA\Property(property="current_address", type="", example="text"),
 * )
 */
class UpdateContactInfoRequest extends FormRequest
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
            'phone_number' => 'numeric',
            'landline_number' => 'numeric',
            'city_of_residence_id' => 'exists:cities,id',
            'email' => 'email|string|unique:contact_infos,email,' . $this->route('student')->id,
            'permanent_address' => '',
            'current_address' => '',
        ];
    }
}
