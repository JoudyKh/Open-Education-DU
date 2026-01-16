<?php

namespace App\Services\General\Student;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function show($student = null)
    {
        $student ?
            $student = Student::findOrFail($student) :
            $student = Auth::guard('student')->user();

        return StudentResource::make($student);
    }
}
