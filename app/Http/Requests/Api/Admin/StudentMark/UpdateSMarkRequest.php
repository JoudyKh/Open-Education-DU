<?php

namespace App\Http\Requests\Api\Admin\StudentMark;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="UpdateStudentMarkRequest",  
 *     type="object",   
 *     @OA\Property(property="student_id", type="integer", example=1, description="The ID of the student"),  
 *     @OA\Property(property="semester_id", type="integer", example=1, description="The ID of the semester"),  
 *     @OA\Property(property="curriculum_id", type="integer", example=1, description="The ID of the curriculum associated with the semester"),  
 *     @OA\Property(property="mark", type="number", format="double", example=85, description="The mark obtained by the student"),  
 *     @OA\Property(property="written_mark", type="string", example="A", description="The written mark representation"),  
 * )  
 */
class UpdateSMarkRequest extends FormRequest
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
        $studentMark = $this->route('studentMark');
        $semesterId = $this->input('semester_id') ?? $studentMark->semester_id;
        $curriculumId = $this->input('curriculum_id') ?? $studentMark->curriculum_id;
        return [
            'student_id' => 'nullable|exists:students,id',
            'curriculum_id' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($semesterId) {
                    $exists = \DB::table('semester_curriculum')
                        ->where('curriculum_id', $value)
                        ->where('semester_id', $semesterId)
                        ->exists();
                        
                    if (!$exists) {
                        $fail('The selected curriculum_id is invalid. It must exist in the semester_curriculum table .');
                    }
                },
            ],
            'semester_id' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($curriculumId) {
                    $exists = \DB::table('semester_curriculum')
                        ->where('semester_id', $value)
                        ->where('curriculum_id', $curriculumId)
                        ->exists();
                    if (!$exists) {
                        $fail('The selected semester id is invalid. It must exist in the semester_curriculum table.');
                    }
                },
            ],
            'mark' => 'nullable|numeric|between:1,100',
            'written_mark' => 'nullable|string|max:255',
        ];
    }
}
