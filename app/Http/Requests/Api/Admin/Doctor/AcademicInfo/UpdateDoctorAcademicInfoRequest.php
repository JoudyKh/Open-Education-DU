<?php

namespace App\Http\Requests\Api\Admin\Doctor\AcademicInfo;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="UpdateDoctorAcademicInfoRequest",  
 *     type="object",  
 *     @OA\Property(property="title", type="string", example="CS101"),  
 *     @OA\Property(property="thesis_title", type="string", example="Computer Science 101"),  
 *     @OA\Property(property="university_name", type="string", example="علوم الكمبيوتر 101"),  
 *     @OA\Property(property="collage_name", type="string", example="علوم الكمبيوتر 101"),  
 *     @OA\Property(property="specialization", type="string", example="علوم الكمبيوتر 101"),  
 *     @OA\Property(property="degree", type="string", example="علوم الكمبيوتر 101"),  
 *     @OA\Property(property="rate", type="number", format="double", example=50),  
 *     @OA\Property(property="graduation_year", type="string", format="date", example="2023-05-15"),
 * )  
 */  
class UpdateDoctorAcademicInfoRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'thesis_title' => 'nullable|string|max:255',
            'university_name' => 'nullable|string|max:255',
            'collage_name' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|date_format:Y-m-d',
            'rate' => 'nullable|numeric',
            'degree' => 'nullable|string|max:255',
        ];
    }
}
