<?php

namespace App\Services\Admin\Doctor;
use App\Http\Requests\Api\Admin\Doctor\AcademicPosition\CreateDoctorAcademicPositionRequest;
use App\Http\Requests\Api\Admin\Doctor\AcademicPosition\UpdateDoctorAcademicPositionRequest;
use App\Http\Resources\DoctorAcademicPositionResource;
use App\Models\Doctor;
use App\Models\DoctorAcademicPosition;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class AcademicPositionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    use SearchTrait;
    public function index(Doctor $doctor, Request $request)
    {
        $positions = $doctor->positions();
        $positions = $positions->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($positions, $request, DoctorAcademicPosition::$searchable);
        $positions = $positions->paginate(config('app.pagination_limit'));
        return DoctorAcademicPositionResource::collection($positions);
    }
        public function store(Doctor $doctor, &$array)
        {
            $doctor->positions()->create($array);
            return DoctorAcademicPositionResource::make($doctor->positions);
        }
    public function show(Doctor $doctor, DoctorAcademicPosition $position)
    {
        return DoctorAcademicPositionResource::make($position);
    }
    public function update(Doctor $doctor, UpdateDoctorAcademicPositionRequest $request, DoctorAcademicPosition $position)
    {
        $data = $request->validated();
        $position->update($data);
        $position = DoctorAcademicPosition::find($position->id);
        return DoctorAcademicPositionResource::make($position);
    }
    public function destroy(Doctor $doctor, $position, $force = null)
    {
        if ($force) {
            $position = DoctorAcademicPosition::onlyTrashed()->findOrFail($position);
            $position->forceDelete();
        } else {
            $position = DoctorAcademicPosition::where('id', $position)->first();
            $position->delete();
        }
        return true;
    }
    public function restore(Doctor $doctor, $position)
    {
        $position = DoctorAcademicPosition::withTrashed()->find($position);
        if ($position && $position->trashed()) {
            $position->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
