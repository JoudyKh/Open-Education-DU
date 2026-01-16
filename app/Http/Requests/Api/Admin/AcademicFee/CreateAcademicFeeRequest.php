<?php

namespace App\Http\Requests\Api\Admin\AcademicFee;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="CreateAcademicFeeRequest",  
 *     type="object",  
 *     @OA\Property(property="fees[0][curriculum_id]", type="string", example="1", description="you can add many array items"),
 *     @OA\Property(property="fees[1][curriculum_id]", type="string", example="1", description="you can add many array items"),
 *     @OA\Property(property="fees[0][student_year]", type="string", type="string", format="date", example="2023-09-01"),
 *     @OA\Property(property="fees[1][student_year]", type="string",  type="string", format="date", example="2023-09-01"),
 *     @OA\Property(property="fees[0][fee]", type="string", example="1", description="you can add many array items"),
 *     @OA\Property(property="fees[1][fee]", type="string", example="1", description="you can add many array items"),
 *     @OA\Property(property="fees[0][student_registrations_count]", type="string", example="1", description="you can add many array items"),
 *     @OA\Property(property="fees[1][student_registrations_count]", type="string", example="1", description="you can add many array items"),
 * )  
 */ 
class CreateAcademicFeeRequest extends FormRequest
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
            'fees' => 'required|array',
            'fees.*.curriculum_id' => 'required|exists:semester_curriculum,curriculum_id,semester_id,' . $this->route('semester')->id,
            'fees.*.student_year' => 'required|date',
            'fees.*.fee' => 'required|numeric',
            'fees.*.student_registrations_count' => 'required|numeric',
        ];
    }
}
