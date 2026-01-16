<?php

namespace App\Http\Requests\Api\Admin\ProgramRule;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CreateProgramRuleRequest",
 *     type="object",
 *     @OA\Property(property="title_ar"),
 *     @OA\Property(property="title_en"),
 *     @OA\Property(property="description_ar"),
 *     @OA\Property(property="description_en"),
 * )
 */
class CreateProgramRuleRequest extends FormRequest
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
            'title_ar' => 'required',
            'title_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
        ];
    }
}
