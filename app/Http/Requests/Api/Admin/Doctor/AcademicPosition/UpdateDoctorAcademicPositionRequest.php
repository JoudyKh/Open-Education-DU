<?php

namespace App\Http\Requests\Api\Admin\Doctor\AcademicPosition;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="UpdateDoctorAcademicPositionRequest",  
 *     type="object",   
 *     @OA\Property(property="name", type="string", example="CS101"),  
 *     @OA\Property(property="start_year", type="string", format="date", example="2023-05-15"),
 *     @OA\Property(property="end_year", type="string", format="date", example="2023-05-15"),
 * )  
 */ 
class UpdateDoctorAcademicPositionRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'start_year' => [
                'nullable',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    $existingEndTime = $this->getExistingEndTime();
                    
                    if ($existingEndTime && $value && $value >= $existingEndTime) {
                        $fail(__('The start date must be before the end date.'));
                    }
                },
            ],
            'end_year' => [
                'nullable',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    $existingStartTime = $this->getExistingStartTime();
                    
                    // If start_time is provided or exists in the database, validate it
                    if ($existingStartTime && $value && $value <= $existingStartTime) {
                        $fail(__('The end date must be after the start date.'));
                    }
                },
            ],
        ];
    }
    protected function getExistingStartTime()
    {
        $examinationDate = $this->route('academicPosition');
        return $this->input('start_year') ?: $examinationDate->start_year;
    }
    
    /**
     * Retrieve the existing end time from the database if it's not in the request.
     */
    protected function getExistingEndTime()
    {
        $examinationDate = $this->route('academicPosition');
        return $this->input('end_year') ?: $examinationDate->end_year;
    }
}
