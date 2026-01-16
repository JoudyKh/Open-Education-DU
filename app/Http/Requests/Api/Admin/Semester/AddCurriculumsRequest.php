<?php

namespace App\Http\Requests\Api\Admin\Semester;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AddCurriculumsRequest",
 *     type="object",
 *     @OA\Property(
 *         property="curriculums[0]",
 *         type="integer",
 *         description="An array of curriculum IDs"
 *     ),
 *     @OA\Property(
 *         property="curriculums[1]",
 *         type="integer",
 *         description="An array of curriculum IDs"
 *     ),
 * )
 */
class AddCurriculumsRequest extends FormRequest
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
            'curriculums' => 'required|array|min:1',
            'curriculums.*' => 'required|exists:curriculums,id',
        ];
    }
}
