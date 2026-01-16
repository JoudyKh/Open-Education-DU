<?php

namespace App\Services\App\StudentMark;
use App\Http\Resources\StudentMarkResource;
use App\Models\Semester;

class StudentMarkService

{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function index(Semester $semester)
    {
        $student = auth()->user();
        // return $student->marks;
        $marks = $student->marks()->where('semester_id', $semester->id)->with(['curriculum'])->paginate(config('app.pagination_limit'));
        return StudentMarkResource::collection($marks);
    }
}
