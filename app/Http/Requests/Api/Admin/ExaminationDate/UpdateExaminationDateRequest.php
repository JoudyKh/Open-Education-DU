<?php

namespace App\Http\Requests\Api\Admin\ExaminationDate;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="UpdateExaminationDateRequest",  
 *     type="object",  
 *   @OA\Property(
 *         property="start_time",
 *                 type="string",
 *                 format="time",
 *                 description="Start time in HH:MM format."
 *     ),   
 *   @OA\Property(
 *         property="end_time",
 *                 type="string",
 *                 format="time",
 *                 description="End time in HH:MM format, must be after start_time."
 *     ),   
 *   @OA\Property(
 *         property="date",
 *                 type="string",
 *                 format="date",
 *                 description=""
 *     ),   
 *   @OA\Property(
 *         property="curriculum_id",
 *         type="integer",
 *         description=""
 *     ),    
 * )  
 */
class UpdateExaminationDateRequest extends FormRequest
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
            'start_time' => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $existingEndTime = $this->getExistingEndTime();
                    
                    if ($existingEndTime && $value && $value >= $existingEndTime) {
                        $fail(__('The start time must be before the end time.'));
                    }
                },
            ],
            'end_time' => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $existingStartTime = $this->getExistingStartTime();
                    
                    // If start_time is provided or exists in the database, validate it
                    if ($existingStartTime && $value && $value <= $existingStartTime) {
                        $fail(__('The end time must be after the start time.'));
                    }
                },
            ],
            'date' => 'nullable|date',
        ];
    }
    
    /**
     * Retrieve the existing start time from the database if it's not in the request.
     */
    protected function getExistingStartTime()
    {
        $examinationDate = $this->route('examinationDate');
        return $this->input('start_time') ?: $examinationDate->start_time;
    }
    
    /**
     * Retrieve the existing end time from the database if it's not in the request.
     */
    protected function getExistingEndTime()
    {
        $examinationDate = $this->route('examinationDate');
        return $this->input('end_time') ?: $examinationDate->end_time;
    }
}
