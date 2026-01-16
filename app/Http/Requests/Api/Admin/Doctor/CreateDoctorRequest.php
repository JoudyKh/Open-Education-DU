<?php

namespace App\Http\Requests\Api\Admin\Doctor;

use App\Constants\Constants;
use Illuminate\Foundation\Http\FormRequest;

/** 
 * @OA\Schema(  
 *     schema="CreateDoctorRequest",  
 *     type="object",  
 *     required={  
 *         "academic_rank", "email", "phone",   
 *         "fax", "mobile",    
 *     },  
 *     @OA\Property(property="academic_rank", type="string", example="CS101"),  
 *     @OA\Property(property="email", type="string", example="email@eamil.com"),  
 *     @OA\Property(property="phone", type="string", example="645634"),  
 *     @OA\Property(property="fax", type="string", example="ghdgdgrd"),  
 *     @OA\Property(property="mobile", type="string", example="85423545"), 
 *     @OA\Property(
 *           property="image",
 *           type="string",
 *           format="binary",
 *       ), 
 *     @OA\Property(property="infos", type="object",  
 *         @OA\Property(property="title", type="string", example="CS101"),  
 *         @OA\Property(property="thesis_title", type="string", example="Computer Science 101"),  
 *         @OA\Property(property="university_name", type="string", example="علوم الكمبيوتر 101"),  
 *         @OA\Property(property="collage_name", type="string", example="علوم الكمبيوتر 101"),  
 *         @OA\Property(property="specialization", type="string", example="علوم الكمبيوتر 101"),  
 *         @OA\Property(property="degree", type="string", example="علوم الكمبيوتر 101"),  
 *         @OA\Property(property="rate", type="number", format="double", example=50),  
 *         @OA\Property(property="graduation_year", type="string", format="date", example="2023-05-15"),
 *     ),  
 *     @OA\Property(property="position", type="object",  
 *         @OA\Property(property="name", type="string", example="CS101"),  
 *         @OA\Property(property="start_year", type="string", format="date", example="2023-05-15"),
 *         @OA\Property(property="end_year", type="string", format="date", example="2023-05-15"),
 *     ),  
 *     @OA\Property(property="achievement", type="object",  
 *         @OA\Property(property="title", type="string", example="CS101"),  
 *         @OA\Property(property="text", type="string", example="Achievement description"),  
 *         @OA\Property(property="type", type="string", enum={"books_and_scientific_publications", "scientific_research", "conferences", "teaching_experience"}), 
 *     ),  
 * )  
 */
class CreateDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if ($this->has('infos')) {
            $this->merge(['infos' => json_decode(request()->input('infos'), true)]);
        }

        if ($this->has('position')) {
            $this->merge(['position' => json_decode(request()->input('position'), true)]);
        }

        if ($this->has('achievement')) {
            $this->merge(['achievement' => json_decode(request()->input('achievement'), true)]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'academic_rank' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'required|string|max:255',
            'fax' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',

            'infos',
            'infos.title' => 'nullable|string|max:255',
            'infos.thesis_title' => 'nullable|string|max:255',
            'infos.university_name' => 'nullable|string|max:255',
            'infos.collage_name' => 'nullable|string|max:255',
            'infos.specialization' => 'nullable|string|max:255',
            'infos.graduation_year' => 'nullable|date_format:Y-m-d',
            'infos.rate' => 'nullable|numeric',
            'infos.degree' => 'nullable|string|max:255',

            'position',
            'position.name' => 'nullable|string|max:255',
            'position.start_year' => [
                'nullable',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    $existingEndTime = $this->getExistingEndTime('position');
                    if ($existingEndTime && $value && $value >= $existingEndTime) {
                        $fail(__('The start year must be before the end year.'));
                    }
                },
            ],
            'position.end_year' => [
                'nullable',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    $existingStartTime = $this->getExistingStartTime('position');
                    if ($existingStartTime && $value && $value <= $existingStartTime) {
                        $fail(__('The end year must be after the start year.'));
                    }
                },
            ],

            'achievement',
            'achievement.title' => 'nullable',
            'achievement.text' => 'nullable',
            'achievement.type' => 'nullable|in:' . implode(',', Constants::DOCTOR_ACHIEVEMENTS_TYPE),
        ];
    }
    protected function getExistingStartTime($type = null)
    {
        return $this->input('position.start_year') ?? null;
    }

    /**
     * Retrieve the existing end year from the database if it's not in the request.
     */
    protected function getExistingEndTime($type = null)
    {
        return $this->input('position.end_year') ?? null;
    }
}
