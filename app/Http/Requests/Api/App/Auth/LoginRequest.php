<?php

namespace App\Http\Requests\Api\App\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;


class LoginRequest extends FormRequest
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
            'national_id' => 'nullable|string|exists:students,national_id',
            'passport_number' => 'nullable|string|exists:students,passport_number',
            'password' => 'required|string',
        ];
    }
}
