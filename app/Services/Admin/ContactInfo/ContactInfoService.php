<?php

namespace App\Services\Admin\ContactInfo;
use App\Http\Requests\Api\Admin\ContactInfo\CreateContactInfoRequest;
use App\Http\Requests\Api\Admin\ContactInfo\UpdateContactInfoRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;

class ContactInfoService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function store(CreateContactInfoRequest $request, Student $student)
    {
        $data = $request->validated();
        $student->info()->create($data);
        return StudentResource::make($student);
    }
    public function update(UpdateContactInfoRequest $request, Student $student)
    {
        $data = $request->validated();
        $student->info()->update($data);
        return StudentResource::make($student);
    }
}
