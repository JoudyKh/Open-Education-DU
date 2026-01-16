<?php

namespace App\Http\Requests\Api\Admin\Student;

use App\Constants\Constants;
use App\Models\Nationality;
use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateStudentRequest",
 *     type="object",
 *     @OA\Property(property="first_name_ar", type="string", maxLength=255, example="أحمد"),
 *     @OA\Property(property="first_name_en", type="string", maxLength=255, example="Ahmad"),
 *     @OA\Property(property="last_name_ar", type="string", maxLength=255, example="الزهيري"),
 *     @OA\Property(property="last_name_en", type="string", maxLength=255, example="Al-Zuhairi"),
 *     @OA\Property(property="father_name_ar", type="string", maxLength=255, example="محمد"),
 *     @OA\Property(property="father_name_en", type="string", maxLength=255, example="Mohammed"),
 *     @OA\Property(property="mother_name_ar", type="string", maxLength=255, example="فاطمة"),
 *     @OA\Property(property="mother_name_en", type="string", maxLength=255, example="Fatima"),
 *     @OA\Property(property="national_id", type="string", maxLength=255, nullable=true, example="1234567890"),
 *     @OA\Property(property="birth_place_ar", type="string", maxLength=255, example="دمشق"),
 *     @OA\Property(property="birth_place_en", type="string", maxLength=255, example="Damascus"),
 *     @OA\Property(property="birth_date", type="string", format="date-time", example="1995-05-15"),
 *     @OA\Property(property="nationality_id", type="integer", example=1),
 *     @OA\Property(property="id_number", type="integer", example=987654321),
 *     @OA\Property(property="gender", type="string", enum={"male", "female"}, example="male"),
 *     @OA\Property(property="is_active", type="integer", enum={"0", "1"}, example="1"),
 *     @OA\Property(property="place_of_registration", type="string", maxLength=255, example="Registration Place"),
 *     @OA\Property(property="registration_number", type="string", maxLength=255, example="123456"),
 *     @OA\Property(property="passport_number", type="string", maxLength=255, nullable=true, example="A12345678"),
 *     @OA\Property(property="recruitment_division", type="string", maxLength=255, nullable=true, example="Division X"),
 *     @OA\Property(property="province_id", type="integer", example=1),
 *     @OA\Property(
 *         property="personal_picture",
 *         type="string",
 *         format="binary",
 *         example="file.jpg"
 *     ),
 *     @OA\Property(
 *         property="id_front_side_image",
 *         type="string",
 *         format="binary",
 *         example="file.jpg"
 *     ),
 *     @OA\Property(
 *         property="id_back_side_image",
 *         type="string",
 *         format="binary",
 *         example="file.jpg"
 *     ),
 *     @OA\Property(property="password", type="string", maxLength=255, example="StrongPassword123"),
 *     @OA\Property(property="phone_number", type="integer", example="09778"),
 *     @OA\Property(property="landline_number", type="integer", example="5332"),
 *     @OA\Property(property="city_of_residence_id", type="integer", example="1"),
 *     @OA\Property(property="email", type="string", example="example@example.com"),
 *     @OA\Property(property="permanent_address", type="", example="text"),
 *     @OA\Property(property="current_address", type="", example="text"),
 *     @OA\Property(property="type", type="string", enum={"Institute_and_high_school", "High_school"}),
 *     @OA\Property(property="high_school_type", type="string", enum={"scientific", "literary", "legitimate"}, example="scientific"),
 *     @OA\Property(property="high_school_certificate_source", type="string", maxLength=255, example="Ministry of Education"),
 *     @OA\Property(property="total_student_score", type="number", format="double", example=2700),
 *     @OA\Property(property="total_certificate_score", type="number", format="double", example=2900),
 *     @OA\Property(property="high_school_year", type="string", format="date", example="2020-05-01"),
 *     @OA\Property(property="differential_rate", type="string", maxLength=255, example="2400"),
 *     @OA\Property(property="english_language_degree", type="string", maxLength=255, example="240"),
 *     @OA\Property(property="french_language_degree", type="string", maxLength=255, example="230"),
 *     @OA\Property(property="religious_education_degree", type="string", maxLength=255, example="100"),
 *     @OA\Property(property="high_school_certificate_language", type="string", enum={"english", "french"}, example="english"),
 *     @OA\Property(property="high_school_certificate_photo", type="string", format="binary", example="certificate_photo.jpg"),
 *     @OA\Property(property="institute_name", type="string", maxLength=255, example="ABC University"),
 *     @OA\Property(property="institute_specialization", type="string", maxLength=255, example="Computer Science"),
 *     @OA\Property(property="graduation_rate", type="number", format="double", example=3.7),
 *     @OA\Property(property="graduation_year", type="string", format="date", example="2023-05-15"),
 *     @OA\Property(property="institute_certificate_image", type="string", format="binary", example="certificate_image.jpg"),
 *     @OA\Property(property="institute_transcript_file", type="string", format="binary", example="transcript_file.pdf"),
 *     @OA\Property(property="document_decisive", type="string", format="binary", example="Final Document")
 * )
 */
class UpdateStudentRequest extends FormRequest
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
        $student = $this->route('student');
        $type = $this->input('type');
        $constantValue = Constants::SYRIAN_NATIONALITY;
        $maleGender = Constants::MALE_GENDER;
        $academicType = Constants::ACADEMIC_TYPES[0];
        $academicInfo = $student->academicInfo;
        return [
            'first_name_ar' => 'string|max:255',
            'first_name_en' => 'string|max:255',
            'last_name_ar' => 'string|max:255',
            'last_name_en' => 'string|max:255',
            'father_name_ar' => 'string|max:255',
            'father_name_en' => 'string|max:255',
            'mother_name_ar' => 'string|max:255',
            'mother_name_en' => 'string|max:255',
            'birth_place_ar' => 'string|max:255',
            'birth_place_en' => 'string|max:255',
            'birth_date' => 'string',
            'nationality_id' => 'exists:nationalities,id',
            'id_number' => 'numeric|unique:students,id_number,' . $student->id,
            'is_active' => 'boolean',
            'recruitment_division' => [
                'nullable',
                'string',
                'max:255',
                $this->conditionalRequired('gender', 'recruitment_division', function () use ($maleGender) {
                    return $this->input('gender') === $maleGender;
                }),
            ],
            'national_id' => [
                'nullable',
                'string',
                'max:255',
                $this->conditionalRequired('nationality_id', 'national_id', function () use ($constantValue) {
                    return $this->matchesConstantValue($constantValue);
                }),
                'unique:students,national_id,' . $student->id,
            ],
            'passport_number' => [
                'nullable',
                'string',
                'max:255',
                'unique:students,passport_number,' . $student->id,
                $this->conditionalRequired('nationality_id', 'passport_number', function () use ($constantValue) {
                    return !$this->matchesConstantValue($constantValue);
                }),
            ],
            'gender' => '',
            'place_of_registration' => 'string',
            'registration_number' => 'string|max:255',
            'province_id' => 'exists:provinces,id',
            'university_id' => 'numeric|regex:/^3\d*/|max:6|unique:students,university_id,' . $student->id,
            'personal_picture' => 'image',
            'id_front_side_image' => 'image',
            'id_back_side_image' => 'image',
            'password' => 'string|max:255',
            'phone_number' => 'numeric',
            'landline_number' => 'numeric',
            'city_of_residence_id' => 'exists:cities,id',
            'email' => 'email|string|unique:contact_infos,email,' . $this->student->id,
            'permanent_address' => '',
            'current_address' => '',
            'type' => 'string|in:' . implode(',', Constants::ACADEMIC_TYPES),
            'high_school_type' => 'string|in:' . implode(',', Constants::HIGH_SCHOOL_TYPES),
            'high_school_certificate_source' => 'string|max:255',
            'total_student_score' => 'numeric',
            'total_certificate_score' => 'numeric',
            'high_school_year' => 'date_format:Y-m-d',
            'differential_rate' => 'string|max:255',
            'english_language_degree' => 'string|max:255',
            'french_language_degree' => 'string|max:255',
            'religious_education_degree' => 'string|max:255',
            'high_school_certificate_language' => 'string|in:english,french',
            'high_school_certificate_photo' => 'image',
            'institute_name' =>  [
                'string',
                'max:255',
                Rule::requiredIf(function () use ($type, $academicInfo, $academicType) {
                    return $type === $academicType && (empty($academicInfo) || empty($academicInfo->institute_name));
                }),
            ],
            'institute_specialization' => [
                'string',
                'max:255',
                Rule::requiredIf(function () use ($type, $academicInfo, $academicType) {
                    return $type === $academicType && (empty($academicInfo) || empty($academicInfo->institute_specialization));
                }),
            ],
            'graduation_rate' => [
                'numeric',
                Rule::requiredIf(function () use ($type, $academicInfo, $academicType) {
                    return $type === $academicType && (empty($academicInfo) || empty($academicInfo->graduation_rate));
                }),
            ],
            'graduation_year' => [
                'date_format:Y-m-d',
                Rule::requiredIf(function () use ($type, $academicInfo, $academicType) {
                    return $type === $academicType && (empty($academicInfo) || empty($academicInfo->graduation_year));
                }),
            ],
            'institute_certificate_image' => 'image',
            'institute_transcript_file' => 'file',
            'document_decisive' => 'file',
        ];
    }
    protected function conditionalRequired($triggerField, $relatedField, $condition)
    {
        $studentId = $this->route('student')->id;
        $relatedFieldValue = Student::find($studentId)->$relatedField;

        return Rule::requiredIf(function () use ($triggerField, $relatedFieldValue, $condition) {
            return $this->has($triggerField) && $condition() && !$relatedFieldValue;
        });
    }
    protected function matchesConstantValue($constantValue)
    {
        $nationality = Nationality::find($this->input('nationality_id'));
        return $nationality && $nationality->en_name === $constantValue;
    }
}
