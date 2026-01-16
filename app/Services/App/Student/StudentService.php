<?php

namespace App\Services\App\Student;
use App\Http\Requests\Api\App\Student\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\AcademicInfo;
use App\Models\ContactInfo;
use App\Models\Student;
use App\Traits\LogsModelChanges;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function update(UpdateStudentRequest $request)
    {
        $excludedModels = [
            \App\Models\Student::class,
        ];

        request()->merge([
            'excluded_models' => implode(',', $excludedModels),
        ]);
        $student =  Auth::guard('student')->user();
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
            foreach ($fileFields as $field => $path) {
                if ($request->hasFile($field)) {
                    $oldFilePaths[$field] = $student->$field ?? $student->academicInfo->$field;

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

}
