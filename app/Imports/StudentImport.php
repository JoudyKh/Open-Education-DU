<?php
namespace App\Imports;

use App\Constants\Constants;
use App\Models\Nationality;
use App\Models\Student;
use App\Models\ContactInfo;
use App\Models\AcademicInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\ValidationException;


class StudentImport implements ToCollection, WithHeadingRow, WithChunkReading, WithValidation
{
    protected $chunkSize = 1000;

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $index => $row) {
                $errors = [];
                $isSyrian = $this->matchesConstantValue($row['nationality_id'], Constants::SYRIAN_NATIONALITY);

                if ($isSyrian) {
                    if (empty($row['national_id'])) {
                        $errors[] = "There was an error on row " . ($index + 1) . ". The national_id field is required.";
                    }
                }else{
                    if (empty($row['passport_number'])) {
                        $errors[] = "There was an error on row " . ($index + 1) . ". The passport_number field is required.";
                    }
                }
                if (!empty($errors)) {  
                    throw ValidationException::withMessages($errors);  
                } 

                $password = $row['password'] ?? null;
                if (!$password) {
                    $password = $row['national_id'] ?? $row['passport_number'];
                }

                $studentData = [
                    'first_name_ar' => $row['first_name_ar'],
                    'first_name_en' => $row['first_name_en'],
                    'last_name_ar' => $row['last_name_ar'],
                    'last_name_en' => $row['last_name_en'],
                    'father_name_ar' => $row['father_name_ar'],
                    'father_name_en' => $row['father_name_en'],
                    'mother_name_ar' => $row['mother_name_ar'],
                    'mother_name_en' => $row['mother_name_en'],
                    'national_id' => $row['national_id'],
                    'birth_place_ar' => $row['birth_place_ar'],
                    'birth_place_en' => $row['birth_place_en'],
                    'birth_date' => $row['birth_date'],
                    'nationality_id' => $row['nationality_id'],
                    'id_number' => $row['id_number'],
                    'gender' => $row['gender'],
                    'place_of_registration' => $row['place_of_registration'],
                    'registration_number' => $row['registration_number'],
                    'passport_number' => $row['passport_number'],
                    'recruitment_division' => $row['recruitment_division'],
                    'province_id' => $row['province_id'],
                    'university_id' => $row['university_id'],
                    'password' => Hash::make($password),
                ];

                $student = Student::create($studentData);
                $student->assignRole(Constants::STUDENT_ROLE);

                $contactInfoData = [
                    'student_id' => $student->id,
                    'phone_number' => $row['phone_number'],
                    'landline_number' => $row['landline_number'],
                    'city_of_residence_id' => $row['city_of_residence_id'],
                    'email' => $row['email'],
                    'permanent_address' => $row['permanent_address'],
                    'current_address' => $row['current_address'],
                ];

                $academicInfoData = [
                    'student_id' => $student->id,
                    'type' => $row['type'],
                    'high_school_type' => $row['high_school_type'],
                    'high_school_certificate_source' => $row['high_school_certificate_source'],
                    'total_student_score' => $row['total_student_score'],
                    'total_certificate_score' => $row['total_certificate_score'],
                    'high_school_year' => $row['high_school_year'],
                    'differential_rate' => $row['differential_rate'],
                    'english_language_degree' => $row['english_language_degree'],
                    'french_language_degree' => $row['french_language_degree'],
                    'religious_education_degree' => $row['religious_education_degree'],
                    'high_school_certificate_language' => $row['high_school_certificate_language'],
                    'institute_name' => $row['institute_name'],
                    'institute_specialization' => $row['institute_specialization'],
                    'graduation_rate' => $row['graduation_rate'],
                    'graduation_year' => $row['graduation_year'],
                ];

                ContactInfo::create($contactInfoData);
                AcademicInfo::create($academicInfoData);
            }
        });
    }

    public function chunkSize(): int
    {
        return $this->chunkSize;
    }
    public function rules(): array
    {
        return [
            'first_name_ar' => 'required|max:255',
            'first_name_en' => 'required|max:255',
            'last_name_ar' => 'required|max:255',
            'last_name_en' => 'required|max:255',
            'father_name_ar' => 'required|max:255',
            'father_name_en' => 'required|max:255',
            'mother_name_ar' => 'required|max:255',
            'mother_name_en' => 'required|max:255',
            'birth_place_ar' => 'nullable|max:255',
            'birth_place_en' => 'nullable|max:255',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'nationality_id' => 'required|exists:nationalities,id',
            'national_id' => [
                'nullable',
                'string',
                'unique:students,national_id',
                'max:255',
            ],
            'recruitment_division' => [
                'nullable',
                'string',
                'max:255',
            ],
            'passport_number' => [
                'nullable',
                'string',
                'unique:students,passport_number',
                'max:255',
            ],
            'id_number' => 'nullable|numeric|unique:students,id_number',
            'gender' => 'nullable|in:male,female',
            'place_of_registration' => 'nullable|max:255',
            'registration_number' => 'nullable|max:255',
            'province_id' => 'nullable|exists:provinces,id',
            'password' => 'nullable|string|max:255',
            'phone_number' => 'nullable|max:20',
            'landline_number' => 'nullable|max:20',
            'city_of_residence_id' => 'nullable|exists:cities,id',
            'email' => 'nullable|email|unique:contact_infos,email',
            'permanent_address' => 'nullable|max:255',
            'current_address' => 'nullable|max:255',
            'type' => 'nullable|in:' . implode(',', Constants::ACADEMIC_TYPES),
            'high_school_type' => 'nullable|in:' . implode(',', Constants::HIGH_SCHOOL_TYPES),
            'high_school_certificate_source' => 'nullable|max:255',
            'total_student_score' => 'nullable|numeric',
            'total_certificate_score' => 'nullable|numeric',
            'high_school_year' => 'nullable|date_format:Y-m-d',
            'differential_rate' => 'nullable|max:255',
            'english_language_degree' => 'nullable|max:255',
            'french_language_degree' => 'nullable|max:255',
            'religious_education_degree' => 'nullable|max:255',
            'high_school_certificate_language' => 'nullable|in:english,french',
            'institute_name' => 'nullable|max:255',
            'institute_specialization' => 'nullable|max:255',
            'graduation_rate' => 'nullable|numeric',
            'graduation_year' => 'nullable|date_format:Y-m-d',
        ];
    }
    protected function matchesConstantValue($nationalityId, $constantValue)
    {
        $nationality = Nationality::find($nationalityId);
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
