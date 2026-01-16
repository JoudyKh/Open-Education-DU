<?php

namespace App\Services\General\Curriculum;
use App\Http\Resources\CurriculumResource;
use App\Http\Resources\CurriculumWithSemesterResource;
use App\Models\Curriculum;
use App\Models\Semester;
use App\Models\StudentMark;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class CurriculumService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    use SearchTrait;
    public function index(Request $request)
    {
        $curriculums = Curriculum::query();

        if ($request->semester_id) {
            $semester = Semester::findOrFail($request->semester_id);
            $curriculums = $semester->curriculums();
        }
        if ($request->student_id) {
            $curriculumIds = StudentMark::where('student_id', $request->student_id)
                ->pluck('curriculum_id');

            $curriculums = $curriculums->whereIn('id', $curriculumIds);
        }
        $curriculums = $curriculums->with('semester')->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($curriculums, $request, Curriculum::$searchable);
        $curriculums = $request->paginate === '0' ? $curriculums->get() : $curriculums->paginate(config('app.pagination_limit'));
        return CurriculumWithSemesterResource::collection($curriculums);
    }
    public function show(Curriculum $curriculum)
    {
        return CurriculumWithSemesterResource::make($curriculum);
    }
}
