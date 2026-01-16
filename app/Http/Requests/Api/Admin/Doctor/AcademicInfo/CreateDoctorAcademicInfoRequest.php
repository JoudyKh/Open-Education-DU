<?php

namespace App\Http\Requests\Api\Admin\Doctor\AcademicInfo;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="CreateDoctorAcademicInfoRequest",  
 *     type="object",  
 *     required={  
 *         "title", "thesis_title", "university_name",   
 *         "collage_name", "specialization",   
 *         "graduation_year", "rate",   
 *         "degree",
 *     },  
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
class CreateDoctorAcademicInfoRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'thesis_title' => 'required|string|max:255',
            'university_name' => 'required|string|max:255',
            'collage_name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'graduation_year' => 'required|date_format:Y-m-d',
            'rate' => 'required|numeric',
            'degree' => 'required|string|max:255',
        ];
    }
}
