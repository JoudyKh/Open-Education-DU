<?php

namespace App\Services\Admin\ExaminationHall;
use App\Http\Requests\Api\Admin\ExaminationHall\CreateExaminationHallRequest;
use App\Http\Requests\Api\Admin\ExaminationHall\UpdateExaminationHallRequest;
use App\Http\Resources\ExaminationHallResource;
use App\Models\ExaminationHall;
use App\Models\Semester;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class ExaminationHallService
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
        $examinationHalls = $semester->examinationHalls();
        $examinationHalls = $examinationHalls->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($examinationHalls, $request, ExaminationHall::$searchable);
        $examinationHalls = $examinationHalls->paginate(config('app.pagination_limit'));
        return ExaminationHallResource::collection($examinationHalls);
    }
    public function store(Semester $semester, CreateExaminationHallRequest $request)
    {
        $data = $request->validated();
        $examinationHall = $semester->examinationHalls()->createMany($data['halls']);
        return ExaminationHallResource::make($examinationHall);
    }
    public function show(Semester $semester, ExaminationHall $examinationHall)
    {
        return ExaminationHallResource::make($examinationHall);
    }
    public function update(Semester $semester, UpdateExaminationHallRequest $request, ExaminationHall $examinationHall)
    {
        $data = $request->validated();
        $examinationHall->update($data);
        $examinationHall = ExaminationHall::find($examinationHall->id);
        return ExaminationHallResource::make($examinationHall);
    }
    public function destroy(Semester $semester, $examinationHall, $force = null)
    {
        if ($force) {
            $examinationHall = ExaminationHall::onlyTrashed()->findOrFail($examinationHall);
            $examinationHall->forceDelete();
        } else {
            $examinationHall = ExaminationHall::where('id', $examinationHall)->first();
            $examinationHall->delete();
        }
        return true;
    }
    public function restore(Semester $semester, $examinationHall)
    {
        $examinationHall = ExaminationHall::withTrashed()->find($examinationHall);
        if ($examinationHall && $examinationHall->trashed()) {
            $examinationHall->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
