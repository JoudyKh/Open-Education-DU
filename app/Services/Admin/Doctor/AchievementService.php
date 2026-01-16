<?php

namespace App\Services\Admin\Doctor;
use App\Http\Requests\Api\Admin\Doctor\Achievement\CreateDoctorAchievementRequest;
use App\Http\Requests\Api\Admin\Doctor\Achievement\UpdateDoctorAchievementRequest;
use App\Http\Resources\DoctorAchievementResource;
use App\Models\Doctor;
use App\Models\DoctorAchievement;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class AchievementService
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
        $achievements = $doctor->achievements();
        $achievements = $achievements->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($achievements, $request, DoctorAchievement::$searchable);
        $achievements = $achievements->paginate(config('app.pagination_limit'));
        return DoctorAchievementResource::collection($achievements);
    }
    public function store(Doctor $doctor, &$array)
    {
        $doctor->achievements()->create($array);
        return DoctorAchievementResource::make($doctor->achievements);
    }
    public function show(Doctor $doctor, DoctorAchievement $achievement)
    {
        return DoctorAchievementResource::make($achievement);
    }
    public function update(Doctor $doctor, UpdateDoctorAchievementRequest $request, DoctorAchievement $achievement)
    {
        $data = $request->validated();
        $achievement->update($data);
        $achievement = DoctorAchievement::find($achievement->id);
        return DoctorAchievementResource::make($achievement);
    }
    public function destroy(Doctor $doctor, $achievement, $force = null)
    {
        if ($force) {
            $achievement = DoctorAchievement::onlyTrashed()->findOrFail($achievement);
            $achievement->forceDelete();
        } else {
            $achievement = DoctorAchievement::where('id', $achievement)->first();
            $achievement->delete();
        }
        return true;
    }
    public function restore(Doctor $doctor, $achievement)
    {
        $achievement = DoctorAchievement::withTrashed()->find($achievement);
        if ($achievement && $achievement->trashed()) {
            $achievement->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
