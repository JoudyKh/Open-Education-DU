<?php

namespace App\Http\Requests\Api\Admin\ExaminationDate;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="CreateExaminationDateRequest",  
 *     type="object",  
 *   @OA\Property(
 *         property="dates[0][start_time]",
 *                 type="string",
 *                 format="time",
 *                 description="Start time in HH:MM format."
 *     ),   
 *   @OA\Property(
 *         property="dates[0][end_time]",
 *                 type="string",
 *                 format="time",
 *                 description="End time in HH:MM format, must be after start_time."
 *     ),   
 *   @OA\Property(
 *         property="dates[0][date]",
 *                 type="string",
 *                 format="date",
 *                 description=""
 *     ),   
 *   @OA\Property(
 *                property="dates[0][curriculum_id]",
 *                type="integer",
 *                description=""
 *     ),    
 * )  
 */

class CreateExaminationDateRequest extends FormRequest
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
            'dates' => 'required|array',
            'dates.*.curriculum_id' => 'required|exists:semester_curriculum,curriculum_id,semester_id,' . $this->route('semester')->id,
            'dates.*.start_time' => 'required|date_format:H:i',
            'dates.*.end_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $existingStartTime = $this->getExistingStartTime();

                    if ($existingStartTime && $value && $value <= $existingStartTime) {
                        $fail(__('The end time must be after the start time.'));
                    }
                },
            ],
            'dates.*.date' => 'required|date',
        ];
    }
    protected function getExistingStartTime()
    {
        $dates = $this->input('dates');
        $currentIndex = (int) last(explode('.', request()->input('attribute')));

        return isset($dates[$currentIndex]) ? $dates[$currentIndex]['start_time'] : null;
    }
}
