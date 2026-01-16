<?php

namespace App\Http\Requests\Api\App\Auth;

use App\Traits\HandlesValidationErrorsTrait;
use App\Constants\Constants;
use App\Models\Nationality;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="SignUpRequest",
 *     type="object",
 *     required={
 *         "first_name_ar", "first_name_en", "last_name_ar", "last_name_en", 
 *         "father_name_ar", "father_name_en", "mother_name_ar", "mother_name_en", 
 *         "nationality_id", "birth_place_ar", "birth_place_en", "birth_date",
 *          "gender", "personal_picture", "id_front_side_image", "id_back_side_image",
 *          "phone_number", "city_of_residence_id", "email", "permanent_address",
 *          "current_address", "type", "high_school_type", "high_school_certificate_source",
 *          "total_student_score", "total_certificate_score", "high_school_year",
 *          "differential_rate", "english_language_degree", "french_language_degree",
 *          "religious_education_degree", "high_school_certificate_language", "high_school_certificate_photo",
 *     },
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
 *         type="string", format="binary",
 *         example="file.jpg"
 *     ),
 *     @OA\Property(property="phone_number", type="string", example="09778"),
 *     @OA\Property(property="landline_number", type="string", example="5332"),
 *     @OA\Property(property="city_of_residence_id", type="integer", example="1"),
 *     @OA\Property(property="email", type="string", example="example@example.com"),
 *     @OA\Property(property="permanent_address", type="string", example="text"),
 *     @OA\Property(property="current_address", type="string", example="text"),
 *     @OA\Property(property="type", type="string", enum={"Institute_and_high_school", "High_school"}),
 *     @OA\Property(property="high_school_type", type="string", enum={"scientific", "literary", "legitimate"}, example="scientific"),
 *     @OA\Property(property="high_school_certificate_source", type="string", maxLength=255, example="Ministry of Education"),
 *     @OA\Property(property="total_student_score", type="number", format="double", example=2700),
 *     @OA\Property(property="total_certificate_score", type="number", format="double", example=2900),
 *     @OA\Property(property="high_school_year", type="string", format="date", example="2020-05-01"),
 *     @OA\Property(property="differential_rate", type="string", maxLength=255, example="2400"),
 *     @OA\Property(property="english_language_degree", type="string", maxLength=255, example="200"),
 *     @OA\Property(property="french_language_degree", type="string", maxLength=255, example="250"),
 *     @OA\Property(property="religious_education_degree", type="string", maxLength=255, example="190"),
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
class SignUpRequest extends FormRequest
{
    use HandlesValidationErrorsTrait;

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
        $constantValue = Constants::SYRIAN_NATIONALITY;
        $maleGender = Constants::MALE_GENDER;
        return [
            'first_name_ar' => 'required|string|max:255',
            'first_name_en' => 'required|string|max:255',
            'last_name_ar' => 'required|string|max:255',
            'last_name_en' => 'required|string|max:255',
            'father_name_ar' => 'required|string|max:255',
            'father_name_en' => 'required|string|max:255',
            'mother_name_ar' => 'required|string|max:255',
            'mother_name_en' => 'required|string|max:255',
            'nationality_id' => 'required|exists:nationalities,id',
            'recruitment_division' => [
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(function () use ($constantValue, $maleGender) {
                    return $this->filled('nationality_id') && $this->matchesConstantValue($constantValue)
                        && $this->input('gender') === $maleGender;
                }),
            ],
            'national_id' => [
                'nullable',
                'string',
                'unique:students,national_id',
                'max:255',
                Rule::requiredIf(function () use ($constantValue) {
                    return $this->filled('nationality_id') && $this->matchesConstantValue($constantValue);
                }),
            ],
            'passport_number' => [
                'nullable',
                'string',
                'unique:students,passport_number',
                'max:255',
                Rule::requiredIf(function () use ($constantValue) {
                    return $this->filled('nationality_id') && !$this->matchesConstantValue($constantValue);
                }),
            ],
            'id_number' => [
                'nullable',
                'numeric',
                Rule::requiredIf(function () use ($constantValue) {
                    return $this->filled('nationality_id') && $this->matchesConstantValue($constantValue);
                }),
            ],
            'place_of_registration' => [
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(function () use ($constantValue) {
                    return $this->filled('nationality_id') && $this->matchesConstantValue($constantValue);
                }),
            ],
            'registration_number' => [
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(function () use ($constantValue) {
                    return $this->filled('nationality_id') && $this->matchesConstantValue($constantValue);
                }),
            ],
            'province_id' => [
                'nullable',
                'exists:provinces,id',
                Rule::requiredIf(function () use ($constantValue) {
                    return $this->filled('nationality_id') && $this->matchesConstantValue($constantValue);
                }),
            ],
            'birth_place_ar' => 'required|string|max:255',
            'birth_place_en' => 'required|string|max:255',
            'birth_date' => 'required|date_format:Y-m-d',
            'gender' => 'required|string|in:male,female',
            'personal_picture' => 'required|image',
            'id_front_side_image' => 'required|image',
            'id_back_side_image' => 'required|image',
            'phone_number' => 'required|string|max:20',
            'landline_number' => 'nullable|string|max:20',
            'city_of_residence_id' => 'required|exists:cities,id',
            'email' => 'required|email|string|unique:contact_infos,email',
            'permanent_address' => 'required|string|max:255',
            'current_address' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', Constants::ACADEMIC_TYPES),
            'high_school_type' => 'required|string|in:' . implode(',', Constants::HIGH_SCHOOL_TYPES),
            'high_school_certificate_source' => 'required|string|max:255',
            'total_student_score' => 'required|numeric',
            'total_certificate_score' => 'required|numeric',
            'high_school_year' => 'required|date_format:Y-m-d',
            'differential_rate' => 'required|string|max:255',
            'english_language_degree' => 'required|string|max:255',
            'french_language_degree' => 'required|string|max:255',
            'religious_education_degree' => 'required|string|max:255',
            'high_school_certificate_language' => 'required|string|in:english,french',
            'high_school_certificate_photo' => 'required|image',
            'institute_name' => 'nullable|required_if:type,' . Constants::ACADEMIC_TYPES[0] . '|string|max:255',
            'institute_specialization' => 'nullable|required_if:type,' . Constants::ACADEMIC_TYPES[0] . '|string|max:255',
            'graduation_rate' => 'nullable|required_if:type,' . Constants::ACADEMIC_TYPES[0] . '|numeric',
            'graduation_year' => 'nullable|required_if:type,' . Constants::ACADEMIC_TYPES[0] . '|date_format:Y-m-d',
            'institute_certificate_image' => 'nullable|image|required_if:type,' . Constants::ACADEMIC_TYPES[0],
            'institute_transcript_file' => 'nullable|file|required_if:type,' . Constants::ACADEMIC_TYPES[0],
            'document_decisive' => 'file',
        ];
    }
    protected function matchesConstantValue($constantValue)
    {
        $nationality = Nationality::where('id', $this->nationality_id)->first();
        return $nationality && $nationality->en_name === $constantValue;
    }

    public function messages()
    {
        return [
            'recruitment_division.required' => 'The recruitment division is required when nationality is syrian.',
            'national_id.required' => 'The national ID is required when nationality is syrian.',
            'passport_number.required' => 'The passport number is required when nationality is not syrian.',
        ];
    }
}
