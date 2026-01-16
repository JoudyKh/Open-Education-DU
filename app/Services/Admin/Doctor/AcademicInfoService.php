<?php

namespace App\Services\Admin\Doctor;
use App\Http\Requests\Api\Admin\Doctor\AcademicInfo\CreateDoctorAcademicInfoRequest;
use App\Http\Requests\Api\Admin\Doctor\AcademicInfo\UpdateDoctorAcademicInfoRequest;
use App\Http\Resources\DoctorAcademicInfoResource;
use App\Models\Doctor;
use App\Models\DoctorAcademicInfo;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class AcademicInfoService
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
        $infos = $doctor->infos();
        $infos = $infos->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($infos, $request, DoctorAcademicInfo::$searchable);
        $infos = $infos->paginate(config('app.pagination_limit'));
        return DoctorAcademicInfoResource::collection($infos);
    }
    public function store(Doctor $doctor, &$array)
    {
        $doctor->infos()->create($array);
        return DoctorAcademicInfoResource::make($doctor->infos);
    }
    public function show(Doctor $doctor, DoctorAcademicInfo $infos)
    {
        return DoctorAcademicInfoResource::make($infos);
    }
    public function update(Doctor $doctor, UpdateDoctorAcademicInfoRequest $request, DoctorAcademicInfo $infos)
    {
        $data = $request->validated();
        $infos->update($data);
        $infos = DoctorAcademicInfo::find($infos->id);
        return DoctorAcademicInfoResource::make($infos);
    }
    public function destroy(Doctor $doctor, $infos, $force = null)
    {
        if ($force) {
            $infos = DoctorAcademicInfo::onlyTrashed()->findOrFail($infos);
            $infos->forceDelete();
        } else {
            $infos = DoctorAcademicInfo::where('id', $infos)->first();
            $infos->delete();
        }
        return true;
    }
    public function restore(Doctor $doctor, $infos)
    {
        $infos = DoctorAcademicInfo::withTrashed()->find($infos);
        if ($infos && $infos->trashed()) {
            $infos->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
