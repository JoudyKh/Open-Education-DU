<?php

namespace App\Http\Requests\Api\Admin\Semester;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;


/**  
 * @OA\Schema(  
 *     schema="UpdateSemesterRequest",  
 *     type="object",  
 *     @OA\Property(property="name", type="string", maxLength=255, example="S13"),  
 *     @OA\Property(property="year", type="string", format="date", example="2023-09-01"),  
 *     @OA\Property(property="start_date", type="string", format="date", example="2023-09-01"),  
 *     @OA\Property(property="end_date", type="string", format="date", example="2024-06-01"),  
 *     @OA\Property(property="registration_start_date", type="string", format="date", example="2023-07-01"),  
 *     @OA\Property(property="registration_end_date", type="string", format="date", example="2023-08-30"),  
 *     @OA\Property(property="has_exception", enum={"0", "1"}),  
 *     @OA\Property(property="max_fail_regular", type="number", format="double", example=2),  
 *     @OA\Property(property="max_fail_dropout", type="number", format="double", example=3),  
 *     @OA\Property(property="count_curriculums_optional", type="number", format="double", example=5),  
 *     @OA\Property(property="count_curriculums_mandatory", type="number", format="double", example=8),
 *     @OA\Property(
 *         property="curriculum_ids[0]",
 *         type="integer",
 *         description="An array of curriculum IDs"
 *     ),  
 *     @OA\Property(
 *         property="delete_curriculums[0]",
 *         type="integer",
 *         description="An array of curriculum IDs want to remove it from this semester"
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][code]",
 *         type="string",
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][name_en]",
 *         type="string",
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][name_ar]",
 *         type="string",
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][min_pass_mark]",
 *         type="double",
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][theoretical_mark]",
 *         type="double",
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][practical_mark]",
 *         type="double",
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][assistances_marks]",
 *         type="double",
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][type]",
 *         enum={"traditional", "automated"},
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][is_optional]",
 *         enum={"0", "1"},
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][in_program]",
 *         enum={"0", "1"},
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][description_file]",
 *         type="string", format="binary",
 *         description="An array of creation curriculums "
 *     ),  
 *     @OA\Property(
 *         property="curriculums[0][year]",
 *         type="integer",
 *         description="An array of creation curriculums "
 *     ), 
 *     @OA\Property(
 *         property="discounts[0][name]",
 *         type="string",
 *         description="An array of discount "
 *     ),  
 *     @OA\Property(
 *         property="discounts[0][percentage]",
 *         type="double",
 *         description="An array of discount "
 *     ),  
 *     @OA\Property(
 *         property="discounts[0][is_exhausted_student]",
 *         enum={"0", "1"},
 *         description="An item of is_exhausted_student "
 *     ),  
 *     @OA\Property(
 *         property="delete_discounts[0]",
 *         type="integer",
 *         description="An array of discount ids want to delete "
 *     ),  
 *     @OA\Property(
 *         property="academic_fees[0][curriculum_id]",
 *         type="integer",
 *         description="An item of curriculums ID"
 *     ),  
 *     @OA\Property(
 *         property="academic_fees[0][student_registrations_count]",
 *         type="integer",
 *         description=""
 *     ),  
 *     @OA\Property(
 *         property="academic_fees[0][fee]",
 *         type="double",
 *         description=""
 *     ),  
 *     @OA\Property(
 *         property="academic_fees[0][student_year]",
 *          type="string", format="date", example="2023-09-01"
 *     ),  
 *     @OA\Property(
 *         property="academic_fees[1][student_year]",
 *          type="string", format="date", example="2023-09-01"
 *     ),  
 *     @OA\Property(
 *         property="delete_academic_fees[0]",
 *          type="integer", 
 *          description="an array of academic_fees want to delete"
 *     ),  
 *    @OA\Property(
 *         property="university_services_fees[0][name]",
 *         type="string",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="university_services_fees[0][fee]",
 *         type="double",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="university_services_fees[0][discount_percentage]",
 *         type="double",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="university_services_fees[0][discount_type_id]",
 *         type="double",
 *         description="discount type ids"
 *     ), 
 *   @OA\Property(
 *         property="delete_university_services_fees[0]",
 *         type="double",
 *         description=" university_services_fees ids want to delete "
 *     ), 
 *   @OA\Property(
 *         property="examination_halls[0][name]",
 *         type="string",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="examination_halls[0][place]",
 *         type="string",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="examination_halls[0][default_capacity]",
 *         type="integer",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="delete_examination_halls[0]",
 *         type="integer",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="examination_dates[0][start_time]",
 *                 type="string",
 *                 format="time",
 *                 description="Start time in HH:MM format.",
 *                  example="04:30"
 *     ),   
 *   @OA\Property(
 *         property="examination_dates[0][end_time]",
 *                 type="string",
 *                 format="time",
 *                 description="End time in HH:MM format, must be after start_time.",
 *                  example="04:30"
 *     ),   
 *   @OA\Property(
 *         property="examination_dates[0][date]",
 *                 type="string",
 *                 format="date",
 *                 description="",
 *                  example="2023-09-01"
 *     ),   
 *   @OA\Property(
 *                property="examination_dates[0][curriculum_id]",
 *                type="integer",
 *                description=""
 *     ),  
 *   @OA\Property(
 *                property="delete_examination_dates[0]",
 *                type="integer",
 *                description="examination_dates ids want to delete"
 *     ),  
 * )  
 */
class UpdateSemesterRequest extends FormRequest
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
            'name' => 'nullable|regex:/^[A-Za-z]\d{2}$/|unique:semesters,name,' . $this->route('semester')->id,
            'year' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'registration_start_date' => 'nullable|date',
            'registration_end_date' => 'nullable|date|after:registration_start_date',
            'has_exception' => 'nullable|boolean',
            'max_fail_regular' => 'nullable|numeric',
            'max_fail_dropout' => 'nullable|numeric',
            'count_curriculums_optional' => 'nullable|numeric',
            'count_curriculums_mandatory' => 'nullable|numeric',

            'curriculum_ids' => 'nullable|array|min:1',
            'curriculum_ids.*' => 'nullable|distinct|exists:curriculums,id',
            'delete_curriculums' => 'nullable|array|min:1',
            'delete_curriculums.*' => 'nullable|distinct|exists:semester_curriculum,id,semester_id,' . $this->route('semester')->id,



            'curriculums' => 'array',
            'curriculums.*.code' => 'required|string|distinct|unique:curriculums,code',

            'curriculums.*.name_en' => 'required|string',
            'curriculums.*.name_ar' => 'required|string',

            'curriculums.*.min_pass_mark' => 'required|numeric|between:1,100',
            'curriculums.*.theoretical_mark' => 'required|numeric|between:1,100',
            'curriculums.*.practical_mark' => 'required|numeric|between:1,100',
            'curriculums.*.assistances_marks' => 'required|numeric|between:1,100',

            'curriculums.*.type' => 'required|in:traditional,automated',

            'curriculums.*.is_optional' => 'required|boolean',
            'curriculums.*.in_program' => 'required|boolean',
            'curriculums.*.description_file' => 'nullable|file',
            'curriculums.*.year' => 'required|numeric|min:1|max:5',




            'discounts' => 'array',
            'discounts.*.name' => 'required|string|max:255',
            'discounts.*.percentage' => 'required|numeric',
            'discounts.*.is_exhausted_student' => 'required|boolean',

            'delete_discounts' => 'array',
            'delete_discounts.*' => 'required|distinct|exists:discounts,id,semester_id,' . $this->route('semester')->id,



            'academic_fees' => 'array',
            'academic_fees.*.curriculum_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $exists = \DB::table('semester_curriculum')
                        ->where('curriculum_id', $value)
                        ->whereNotIn('id', $this->input('delete_curriculums', []))
                        ->exists();

                    $inCurriculumIds = in_array($value, $this->input('curriculum_ids', []));

                    if (!$exists && !$inCurriculumIds) {
                        $fail('The selected curriculum_id is invalid. It must either exist in the semester_curriculum table or be in the curriculum_ids array.');
                    }
                },
            ],
            'academic_fees.*.student_year' => 'required|date',
            'academic_fees.*.fee' => 'required|numeric',
            'academic_fees.*.student_registrations_count' => 'required|numeric',

            'delete_academic_fees' => 'array',
            'delete_academic_fees.*' => 'required|distinct|exists:academic_fees,id,semester_id,' . $this->route('semester')->id,



            'university_services_fees' => 'array',
            'university_services_fees.*.name' => 'required|string|max:255',
            'university_services_fees.*.fee' => 'required|numeric',
            'university_services_fees.*.discount_percentage' => 'required|numeric',
            'university_services_fees.*.discount_type_id' => [
                'required',
                'integer',
                Rule::exists('discount_types', 'id')->whereNull('deleted_at')
            ],

            'delete_university_services_fees' => 'array',
            'delete_university_services_fees.*' => 'required|exists:university_services_fees,id,semester_id,' . $this->route('semester')->id,



            'examination_halls' => 'array',
            'examination_halls.*.name' => 'required|string|max:255',
            'examination_halls.*.place' => 'required|string|max:255',
            'examination_halls.*.default_capacity' => 'required|numeric',

            'delete_examination_halls' => 'array',
            'delete_examination_halls.*' => 'required|exists:examination_halls,id,semester_id,' . $this->route('semester')->id,



            'examination_dates' => 'array',
            'examination_dates.*.curriculum_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = \DB::table('semester_curriculum')
                        ->where('curriculum_id', $value)
                        ->whereNotIn('id', $this->input('delete_curriculums', []))
                        ->exists();

                    $inCurriculumIds = in_array($value, $this->input('curriculum_ids', []));

                    if (!$exists && !$inCurriculumIds) {
                        $fail('The selected curriculum_id is invalid. It must either exist in the semester_curriculum table or be in the curriculum_ids array.');
                    }
                },
            ],
            'examination_dates.*.start_time' => 'required|date_format:H:i',
            'examination_dates.*.end_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $existingStartTime = $this->getExistingStartTime();

                    if ($existingStartTime && $value && $value <= $existingStartTime) {
                        $fail(__('The end time must be after the start time.'));
                    }
                },
            ],
            'examination_dates.*.date' => 'required|date',

            'delete_examination_dates' => 'array',
            'delete_examination_dates.*' => 'required|exists:examination_dates,id,semester_id,'. $this->route('semester')->id,

        ];
    }
    protected function getExistingStartTime()
    {
        $dates = $this->input('examination_dates');
        $currentIndex = (int) last(explode('.', request()->input('attribute')));

        return isset($dates[$currentIndex]) ? $dates[$currentIndex]['start_time'] : null;
    }
    public function messages()
    {
        return [
            'name.regex' => 'The name must contain only a letter and two digits, example Q20',
        ];
    }
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $curriculums = $this->input('curriculums', []);

            foreach ($curriculums as $index => $curriculum) {
                $theoreticalMark = $curriculum['theoretical_mark'] ?? 0;
                $practicalMark = $curriculum['practical_mark'] ?? 0;

                if ($theoreticalMark + $practicalMark !== 100) {
                    $validator->errors()->add("curriculums.$index", 'The sum of theoretical_mark and practical_mark must be exactly 100.');
                }
            }
        });
    }

}
