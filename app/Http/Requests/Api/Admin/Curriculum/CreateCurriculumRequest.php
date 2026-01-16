<?php

namespace App\Http\Requests\Api\Admin\Curriculum;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="CreateCurriculumRequest",  
 *     type="object",  
 *     required={  
 *         "code", "name_en", "name_ar",   
 *         "min_pass_mark", "theoretical_mark",   
 *         "practical_mark", "assistances_marks",   
 *         "type", "is_optional", "in_program", "year", "semester_id",  
 *     },  
 *     @OA\Property(property="code", type="string", example="CS101"),  
 *     @OA\Property(property="name_en", type="string", example="Computer Science 101"),  
 *     @OA\Property(property="name_ar", type="string", example="علوم الكمبيوتر 101"),  
 *     @OA\Property(property="min_pass_mark", type="number", format="double", example=50),  
 *     @OA\Property(property="theoretical_mark", type="number", format="double", example=50),  
 *     @OA\Property(property="practical_mark", type="number", format="double", example=50),  
 *     @OA\Property(property="assistances_marks", type="number", format="double", example=10),  
 *     @OA\Property(property="type", type="string", enum={"traditional", "automated"}, example="traditional"),  
 *     @OA\Property(property="is_optional", type="boolean", enum={"0", "1"}),
 *     @OA\Property(property="in_program", type="boolean", enum={"0", "1"}),
 *     @OA\Property(property="description_file", type="string", format="binary", example="Final Document"),  
 *     @OA\Property(property="year", type="integer", example="4"),  
 *     @OA\Property(property="semester_id", type="integer", example="2"),  
 * )  
 */  
class CreateCurriculumRequest extends FormRequest
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
            'code' => 'required|string|unique:curriculums,code',
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'min_pass_mark' => 'required|numeric|between:1,100',
            'theoretical_mark' => 'required|numeric|between:1,100',
            'practical_mark' => 'required|numeric|between:1,100',
            'assistances_marks' => 'required|numeric|between:1,100',
            'type' => 'required|in:traditional,automated',
            'is_optional' => 'required|boolean',
            'description_file' => 'nullable|file',
            'in_program' => 'required|boolean',
            'year' => 'required|numeric|min:1|max:5',
            'semester_id' => 'required|exists:semesters,id',
        ];
    }
    public function withValidator($validator)  
    {  
        $validator->after(function ($validator) {  
            $theoreticalMark = $this->input('theoretical_mark');  
            $practicalMark = $this->input('practical_mark');  

            if ($theoreticalMark + $practicalMark !== 100) {
                $validator->errors()->add('sum', 'The sum of theoretical_mark and practical_mark must be exactly 100.');
            }  
        });  
    }  
}
