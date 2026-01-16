<?php

namespace App\Http\Requests\Api\Admin\ContactInfo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CreateContactInfoRequest",
 *     type="object",
 *     required={
 *         "phone_number", "landline_number", "city_of_residence_id", "email", "permanent_address", "current_address"
 *     },
 *     @OA\Property(property="phone_number", type="integer", example="09778"),
 *     @OA\Property(property="landline_number", type="integer", example="5332"),
 *     @OA\Property(property="city_of_residence_id", type="integer", example="1"),
 *     @OA\Property(property="email", type="string", example="example@example.com"),
 *     @OA\Property(property="permanent_address", type="", example="text"),
 *     @OA\Property(property="current_address", type="", example="text"),
 * )
 */
class CreateContactInfoRequest extends FormRequest
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
            'phone_number' => 'required|numeric',
            'landline_number' => 'required|numeric',
            'city_of_residence_id' => 'required|exists:cities,id',
            'email' => 'required|email|string|unique:contact_infos,email',
            'permanent_address' => 'required',
            'current_address' => 'required',
        ];
    }
}
