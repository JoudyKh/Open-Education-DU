<?php

namespace App\Services\Admin\ExaminationDate;
use App\Http\Requests\Api\Admin\ExaminationDate\CreateExaminationDateRequest;
use App\Http\Requests\Api\Admin\ExaminationDate\UpdateExaminationDateRequest;
use App\Http\Resources\ExaminationDateResource;
use App\Models\ExaminationDate;
use App\Models\Semester;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class ExaminationDateService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    use SearchTrait;
    public function index(Semester $semester, Request $request)
    {
        $examinationDates = $semester->examinationDates();
        $examinationDates = $examinationDates->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($examinationDates, $request, ExaminationDate::$searchable);
        $examinationDates = $examinationDates->paginate(config('app.pagination_limit'));
        return ExaminationDateResource::collection($examinationDates);
    }
    public function store(Semester $semester, CreateExaminationDateRequest $request)
    {
        $data = $request->validated();
        $examinationDate = $semester->examinationDates()->createMany($data['dates']);
        return ExaminationDateResource::make($examinationDate);
    }
    public function show(Semester $semester, ExaminationDate $examinationDate)
    {
        return ExaminationDateResource::make($examinationDate);
    }
    public function update(Semester $semester, UpdateExaminationDateRequest $request, ExaminationDate $examinationDate)
    {
        $data = $request->validated();
        $examinationDate->update($data);
        $examinationDate = ExaminationDate::find($examinationDate->id);
        return ExaminationDateResource::make($examinationDate);
    }
    public function destroy(Semester $semester, $examinationDate, $force = null)
    {
        if ($force) {
            $examinationDate = ExaminationDate::onlyTrashed()->findOrFail($examinationDate);
            $examinationDate->forceDelete();
        } else {
            $examinationDate = ExaminationDate::where('id', $examinationDate)->first();
            $examinationDate->delete();
        }
        return true;
    }
    public function restore(Semester $semester, $examinationDate)
    {
        $examinationDate = ExaminationDate::withTrashed()->find($examinationDate);
        if ($examinationDate && $examinationDate->trashed()) {
            $examinationDate->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
