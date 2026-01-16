<?php

namespace App\Services\App\Auth;

use App\Constants\Constants;
use App\Constants\Notifications;
use App\Http\Requests\Api\App\Auth\LoginRequest;
use App\Http\Requests\Api\App\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\App\Auth\SignUpRequest;
use App\Http\Requests\Api\General\Auth\UpdateProfileRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\UserRecourse;
use App\Models\Student;
use App\Models\User;
use App\Services\Admin\Student\StudentService;
use App\Services\General\Notification\NotificationService;
use App\Services\General\User\UserService;
use App\Traits\LogsModelChanges;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthService
{

    public function __construct(protected NotificationService $notificationService)
    {
    }



    public function register(SignUpRequest $request, $role = Constants::STUDENT_ROLE): array
    {
        $excludedModels = [
            \App\Models\Student::class,
        ];

        request()->merge([
            'excluded_models' => implode(',', $excludedModels),
        ]);
        \Log::emergency('Excluded Models function: ',  [implode(',', $excludedModels)]); 
        $data = $request->validated();
        $data['student_type'] = Constants::STUDENTS_TYPES[1];

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
            $this->notificationService->pushAdminsNotifications(Notifications::NEW_REGISTRATION, $student);
            return ['student' =>  StudentResource::make($student)];
        } catch (\Throwable $th) {
            foreach ($storedFilePaths as $filePath) {
                Storage::disk('public')->delete($filePath);
            }

            throw $th;
        }
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $student = Student::where(function ($query) use ($data) {
            if (isset($data['national_id'])) {
                $query->where('national_id', $data['national_id']);
            } else {
                $query->where('passport_number', $data['passport_number']);
            }
        })->first();

        if ($student && Hash::check($data['password'], $student->password)) {
            $message = null;
            if (
                $student->is_default == 1 &&
                (Hash::check($student->national_id, $student->password) ||
                    Hash::check($student->passport_number, $student->password))
            ) {
                $message = __('messages.have_to_reset_password');
            }

            $token = $student->createToken('auth')->plainTextToken;
            return success(['student' => $student, 'token' => $token, 'message' => $message]);
        }

        throw new \Exception(__('messages.invalid_data'), 422);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $excludedModels = [
            \App\Models\Student::class,
        ];

        request()->merge([
            'excluded_models' => implode(',', $excludedModels),
        ]);
        $data = $request->validated();
        $id = Auth::guard('student')->id();
        $student = Student::find($id);
        $data['password'] = Hash::make($data['password']);
        $data['is_default'] = 0;
        $student->update($data);
        return true;
    }

}
