<?php

namespace App\Http\Requests\Api\Admin\AcademicFee;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="UpdateAcademicFeeRequest",  
 *     type="object",   
 *     @OA\Property(property="curriculum_id", type="integer", example="1", description="curriculum id, you can add many array items"),
 *     @OA\Property(property="delete_curriculums[0]", type="integer", example="1", description="you can add many array items"),
 *     @OA\Property(property="delete_curriculums[1]", type="integer", example="1", description="you can add many array items"),
 *     @OA\Property(property="student_year", type="string", format="date", example="2023-09-01"),  
 *     @OA\Property(property="fee", type="number", format="double", example=50), 
 *     @OA\Property(property="student_registrations_count", type="integer", example="1"), 
 * )  
 */
class UpdateAcademicFeeRequest extends FormRequest
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
            'curriculum_id' => 'nullable|exists:semester_curriculum,curriculum_id,semester_id,' . $this->route('semester')->id,
            'delete_curriculums' => 'nullable|array|min:1',
            'delete_curriculums.*' => 'nullable|exists:academic_fees,curriculum_id,semester_id,' . $this->route('semester')->id,
            'student_year' => 'nullable|date',
            'fee' => 'nullable|numeric',
            'student_registrations_count' => 'nullable|numeric',
        ];
    }

}
