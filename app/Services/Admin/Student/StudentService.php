<?php

namespace App\Services\Admin\Student;
use App\Constants\Constants;
use App\Http\Requests\Api\Admin\Student\CreateStudentRequest;
use App\Http\Requests\Api\Admin\Student\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\AcademicInfo;
use App\Models\ContactInfo;
use App\Models\Student;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentService
{
    /**
     * Create a new class instance.
     */
    use SearchTrait;
    public function index($request)
    {
        $students = Student::orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($students, $request, Student::$searchable);
        $students = $request->paginate === '0' ? $students->get() : $students->paginate(config('app.pagination_limit'));
        return StudentResource::collection($students);
    }
    public function store(CreateStudentRequest $request, $role = Constants::STUDENT_ROLE)
    {
        $data = $request->validated();
        $data['student_type'] = Constants::STUDENTS_TYPES[0];

        $fileFields = [
            'personal_picture' => 'students/images',
            'id_front_side_image' => 'students/images',
            'id_back_side_image' => 'students/images',
            'high_school_certificate_photo' => 'students/academic/images',
            'institute_certificate_image' => 'students/academic/images',
            'institute_transcript_file' => 'students/academic/file',
            'document_decisive' => 'students/academic/file',
        ];

        $storedFilePaths = [];

        try {
            foreach ($fileFields as $field => $path) {
                if ($request->hasFile($field)) {
                    $storedFilePaths[$field] = $request->file($field)->storePublicly($path, 'public');
                    $data[$field] = $storedFilePaths[$field];
                }
            }

            $password = Hash::make($data['password'] ?? $data['national_id'] ?? $data['passport_number']);
            $data['password'] = $password;
            $student = Student::create($data);
            $student->assignRole($role);
            $student->contactInfo()->create($data);
            $student->academicInfo()->create($data);
            return StudentResource::make($student);
        } catch (\Throwable $th) {
            foreach ($storedFilePaths as $filePath) {
                Storage::disk('public')->delete($filePath);
            }

            throw $th;
        }
    }
    public function import(Request $request)
    {
        $sheet = $request->file('excel_file')->store('files');
        Excel::import(new StudentImport, $sheet);
        return true;
    }
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $data = $request->validated();
        $fileFields = [
            'personal_picture' => 'students/images',
            'id_front_side_image' => 'students/images',
            'id_back_side_image' => 'students/images',
            'high_school_certificate_photo' => 'students/academic/images',
            'institute_certificate_image' => 'students/academic/images',
            'institute_transcript_file' => 'students/academic/file',
            'document_decisive' => 'students/academic/file',
        ];


        $oldFilePaths = [];
        $newFilePaths = [];

        try {
            // Loop through the file fields and handle uploads  
            foreach ($fileFields as $field => $path) {
                if ($request->hasFile($field)) {
                    // Store the old file path for potential rollback
                    $oldFilePaths[$field] = $student->$field ?? $student->academicInfo->$field;

                    // Upload new file and store its path
                    $newFilePaths[$field] = $request->file($field)->storePublicly($path, 'public');
                    $data[$field] = $newFilePaths[$field];
                }
            }




            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $student->update($data);
            $contact = collect($data)->only(ContactInfo::$collectionData)->toArray();
            $academic = collect($data)->only(AcademicInfo::$collectionData)->toArray();
            $student->updateContactInfo($contact);
            $student->updateAcademicInfo($academic);


            foreach ($oldFilePaths as $field => $oldFilePath) {
                if ($oldFilePath && Storage::exists("public/$oldFilePath")) {
                    Storage::delete("public/$oldFilePath");
                }
            }
            $student = Student::find($student->id);
            return StudentResource::make($student);
        } catch (\Throwable $th) {
            foreach ($newFilePaths as $field => $newFilePath) {
                if (Storage::exists("public/$newFilePath")) {
                    Storage::delete("public/$newFilePath");
                }
            }

            throw $th;
        }

    }
    public function destroy($id, $force = null)
    {
        if ($force) {
            $student = Student::onlyTrashed()->find($id);
            if (!$student) {
                throw new \Exception('messages.not_found', 404);
            }
            $fileFields = [
                'personal_picture',
                'id_front_side_image',
                'id_back_side_image',
                'high_school_certificate_photo',
                'institute_certificate_image',
                'institute_transcript_file',
                'document_decisive',
            ];

            // Loop through the image fields and delete if they exist  
            foreach ($fileFields as $field) {
                // Check in the student object first, then in the academicInfo  
                $imagePath = $student->$field ?? ($student->academicInfo ? $student->academicInfo->$field : null);

                if ($imagePath && Storage::exists("public/$imagePath")) {
                    Storage::delete("public/$imagePath");
                }
            }

            $student->forceDelete();
        } else {
            $student = Student::where('id', $id)->first();
            if (!$student) {
                throw new \Exception('messages.not_found', 404);
            }
            $student->delete();
        }

        return true;
    }
    public function restore($id)
    {
        $student = Student::withTrashed()->find($id);
        if ($student && $student->trashed()) {
            $student->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
