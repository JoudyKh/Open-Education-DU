<?php

namespace App\Services\Admin\Semester;
use App\Constants\Constants;
use App\Http\Requests\Api\Admin\Semester\CreateSemesterRequest;
use App\Http\Requests\Api\Admin\Semester\UpdateSemesterRequest;
use App\Http\Resources\SemesterResource;
use App\Models\Curriculum;
use App\Models\Semester;
use App\Traits\LogsModelChanges;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SemesterService
{
    /**
     * Create a new class instance.
     */
    protected $isAdmin;
    public function __construct()
    {
        $this->isAdmin = Auth::user()?->hasRole(Constants::SUPER_ADMIN_ROLE);
    }
    use SearchTrait;
    public function index(Request $request)
    {
        $semesters = Semester::orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($semesters, $request, Semester::$searchable);
        $semesters = $semesters->paginate(config('app.pagination_limit'));
        return SemesterResource::collection($semesters);
    }
    public function store(CreateSemesterRequest $request)
    {
        $data = $request->validated();
        $semester = Semester::create($data);
        $curriculumsIds = [];
        $excludedModels = [
            \App\Models\Curriculum::class,
            \App\Models\Discount::class,
            \App\Models\AcademicFee::class,
            \App\Models\UniversityServicesFee::class,
            \App\Models\ExaminationDate::class,
            \App\Models\ExaminationHall::class,
        ];

        request()->merge([
            'excluded_models' => implode(',', $excludedModels),
        ]);
        if (isset($data['curriculum_ids'])) {
            $curriculumsIds = array_map('intval', $data['curriculum_ids']);
        }

        if (isset($data['curriculums'])) {
            foreach ($data['curriculums'] as $curriculumData) {
                if (isset($curriculumData['description_file'])) {
                    $curriculumData['description_file'] = $curriculumData['description_file']->storePublicly('curriculums/file', 'public');
                }
                $curriculumData['semester_id'] = $semester->id;
                $curriculum = Curriculum::create($curriculumData);
                $curriculumsIds[] = (int) $curriculum->id;
            }
        }

        if (!empty($curriculumsIds)) {
            $semester->curriculums()->attach($curriculumsIds);
        }
        if (isset($data['discounts'])) {
            $semester->discounts()->createMany($data['discounts']);
        }
        if (isset($data['academic_fees'])) {
            $semester->academicFees()->createMany($data['academic_fees']);
        }
        if (isset($data['university_services_fees'])) {
            $semester->universityServicesFees()->createMany($data['university_services_fees']);
        }
        if (isset($data['examination_halls'])) {
            $semester->examinationHalls()->createMany($data['examination_halls']);
        }
        if (isset($data['examination_dates'])) {
            $semester->examinationDates()->createMany($data['examination_dates']);
        }


        return SemesterResource::make($semester);
    }
    public function update(UpdateSemesterRequest $request, Semester $semester)
    {
        $data = $request->validated();
        $semester->update($data);
        $curriculumsIds = [];
        $excludedModels = [
            \App\Models\Curriculum::class,
            \App\Models\Discount::class,
            \App\Models\AcademicFee::class,
            \App\Models\UniversityServicesFee::class,
            \App\Models\ExaminationDate::class,
            \App\Models\ExaminationHall::class,
        ];

        request()->merge([
            'excluded_models' => implode(',', $excludedModels),
        ]);
        if (isset($data['curriculum_ids'])) {
            $curriculumsIds = array_map('intval', $data['curriculum_ids']);
        }
        if (isset($data['curriculums'])) {
            foreach ($data['curriculums'] as $curriculumData) {
                if (isset($curriculumData['description_file'])) {
                    $curriculumData['description_file'] = $curriculumData['description_file']->storePublicly('curriculums/file', 'public');
                }
                $curriculumData['semester_id'] = $semester->id;
                $curriculum = Curriculum::create($curriculumData);
                $curriculumsIds[] = (int) $curriculum->id;
            }
        }
        if (!empty($curriculumsIds)) {
            $semester->curriculums()->attach($curriculumsIds);
        }
        if (isset($data['delete_curriculums'])) {
            $semester->curriculums()->detach($data['delete_curriculums']);
        }
        if (isset($data['discounts'])) {
            $semester->discounts()->createMany($data['discounts']);
        }
        if (isset($data['delete_discounts'])) {
            $semester->discounts()->whereIn('id', $data['delete_discounts'])->delete();
        }
        if (isset($data['academic_fees'])) {
            $semester->academicFees()->createMany($data['academic_fees']);
        }
        if (isset($data['delete_academic_fees'])) {
            $semester->academicFees()->whereIn('id', $data['delete_academic_fees'])->delete();
        }
        if (isset($data['university_services_fees'])) {
            $semester->universityServicesFees()->createMany($data['university_services_fees']);
        }
        if (isset($data['delete_university_services_fees'])) {
            $semester->universityServicesFees()->whereIn('id', $data['delete_university_services_fees'])->delete();
        }
        if (isset($data['examination_halls'])) {
            $semester->examinationHalls()->createMany($data['examination_halls']);
        }
        if (isset($data['delete_examination_halls'])) {
            $semester->examinationHalls()->whereIn('id', $data['delete_examination_halls'])->delete();
        }
        if (isset($data['examination_dates'])) {
            $semester->examinationDates()->createMany($data['examination_dates']);
        }
        if (isset($data['delete_examination_dates'])) {
            $semester->examinationDates()->whereIn('id', $data['delete_examination_dates'])->delete();
        }
        $semester = Semester::find($semester->id);
        return SemesterResource::make($semester);
    }
    public function destroy($semester, $force = null)
    {
        if ($force) {
            $semester = Semester::onlyTrashed()->findOrFail($semester);
            $semester->forceDelete();
        } else {
            $semester = Semester::where('id', $semester)->first();
            $semester->delete();
        }
        return true;
    }
    public function restore($semester)
    {
        $semester = Semester::withTrashed()->find($semester);
        if ($semester && $semester->trashed()) {
            $semester->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
