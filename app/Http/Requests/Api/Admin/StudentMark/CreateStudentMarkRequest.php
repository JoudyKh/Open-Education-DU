<?php

namespace App\Http\Requests\Api\Admin\StudentMark;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="CreateStudentMarkRequest",  
 *     type="object",  
 *     required={  
 *         "semester_id", "curriculum_id", "mark", "written_mark" , "student_id", 
 *     },  
 *     @OA\Property(property="student_id", type="integer", example=1, description="The ID of the student"),  
 *     @OA\Property(property="semester_id", type="integer", example=1, description="The ID of the semester"),  
 *     @OA\Property(property="curriculum_id", type="integer", example=1, description="The ID of the curriculum associated with the semester"),  
 *     @OA\Property(property="mark", type="number", format="double", example=85, description="The mark obtained by the student"),  
 *     @OA\Property(property="written_mark", type="string", example="A", description="The written mark representation"),  
 * )  
 */  
class CreateStudentMarkRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'curriculum_id' => 'required|exists:semester_curriculum,curriculum_id,semester_id,' . $this->input('semester_id'),
            'mark' => 'required|numeric|between:1,100',
            'written_mark' => 'required|string|max:255',
        ];
    }
}
