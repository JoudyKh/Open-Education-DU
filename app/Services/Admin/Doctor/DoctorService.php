<?php

namespace App\Services\Admin\Doctor;
use App\Http\Requests\Api\Admin\Doctor\CreateDoctorRequest;
use App\Http\Requests\Api\Admin\Doctor\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected AcademicInfoService $academicInfoService, protected AcademicPositionService $academicPositionService, protected AchievementService $achievementService)
    {
    }
    use SearchTrait;
    public function index(Request $request)
    {
        $doctors = Doctor::with('image')->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($doctors, $request, Doctor::$searchable);
        $doctors = $doctors->paginate(config('app.pagination_limit'));
        return DoctorResource::collection($doctors);
    }
    public function store(CreateDoctorRequest $request)
    {
        $data = $request->validated();
        $doctor = Doctor::create($data);
        if ($request->hasFile('image')) {
            $image = $data['image']->storePublicly('doctors/images', 'public');
            $doctor->image()->create(['image' => $image]);
        }
        if (isset($data['infos']))
            $this->academicInfoService->store($doctor, $data['infos']);
        if (isset($data['position']))
            $this->academicPositionService->store($doctor, $data['position']);
        if (isset($data['achievement']))
            $this->achievementService->store($doctor, $data['achievement']);
        return DoctorResource::make($doctor);
    }
    public function show(Doctor $doctor)
    {
        return DoctorResource::make($doctor);
    }
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($doctor->image) {
                if (Storage::exists("public/{$doctor->image->image}")) {
                    Storage::delete("public/{$doctor->image->image}");
                }
                $doctor->image()->delete();
            }
            $image = $data['image']->storePublicly('doctors/images', 'public');
            $doctor->image()->create(['image' => $image]);
        }
        $doctor->update($data);

        // if (isset($data['infos']))
        //     $this->academicInfoService->store($doctor, $data['infos']);
        // if (isset($data['delete_infos']))
        //     foreach ($data['delete_infos'] as $infos)
        //         $this->academicInfoService->destroy($doctor, $infos);

        // if (isset($data['position']))
        //     $this->academicPositionService->store($doctor, $data['position']);
        // if (isset($data['delete_positions']))
        //     foreach ($data['delete_positions'] as $position)
        //         $this->academicPositionService->destroy($doctor, $position);

        // if (isset($data['achievement']))
        //     $this->achievementService->store($doctor, $data['achievement']);
        // if (isset($data['delete_achievements']))
        //     foreach ($data['delete_achievements'] as $achievement)
        //         $this->achievementService->destroy($doctor, $achievement);

        $doctor = Doctor::find($doctor->id);
        return DoctorResource::make($doctor);
    }
    public function destroy($doctor, $force = null)
    {
        if ($force) {
            $doctor = Doctor::onlyTrashed()->findOrFail($doctor);
            $doctor->forceDelete();
        } else {
            $doctor = Doctor::where('id', $doctor)->first();
            $doctor->delete();
        }
        return true;
    }
    public function restore($doctor)
    {
        $doctor = Doctor::withTrashed()->find($doctor);
        if ($doctor && $doctor->trashed()) {
            $doctor->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
