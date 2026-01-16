<?php

namespace App\Services\Admin\AcademicFee;
use App\Http\Requests\Api\Admin\AcademicFee\CreateAcademicFeeRequest;
use App\Http\Requests\Api\Admin\AcademicFee\UpdateAcademicFeeRequest;
use App\Http\Resources\AcademicFeeResource;
use App\Models\AcademicFee;
use App\Models\Semester;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class AcademicFeeService
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
        $academicFees = $semester->academicFees();
        $academicFees = $academicFees->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($academicFees, $request, AcademicFee::$searchable);
        $academicFees = $academicFees->paginate(config('app.pagination_limit'));
        return AcademicFeeResource::collection($academicFees);
    }
    public function store(Semester $semester, CreateAcademicFeeRequest $request)
    {
        $data = $request->validated();
        $semester->academicFees()->createMany($data['fees']);
        return AcademicFeeResource::collection($semester->academicFees);
    }
    public function show(Semester $semester, AcademicFee $academicFee)
    {
        return AcademicFeeResource::make($academicFee);
    }
    public function update(Semester $semester, UpdateAcademicFeeRequest $request, AcademicFee $academicFee)
    {
        $data = $request->validated();
        $academicFee->update($data);
        if (isset($data['delete_curriculums'])) {
            AcademicFee::where('semester_id', $semester->id)
                ->whereIn('curriculum_id', $data['delete_curriculums'])
                ->delete();
        }
        $academicFee = AcademicFee::find($academicFee->id);
        return AcademicFeeResource::make($academicFee);
    }
    public function destroy(Semester $semester, $academicFee, $force = null)
    {
        if ($force) {
            $academicFee = AcademicFee::onlyTrashed()->findOrFail($academicFee);
            $academicFee->forceDelete();
        } else {
            $academicFee = AcademicFee::where('id', $academicFee)->first();
            $academicFee->delete();
        }
        return true;
    }
    public function restore(Semester $semester, $academicFee)
    {
        $academicFee = AcademicFee::withTrashed()->find($academicFee);
        if ($academicFee && $academicFee->trashed()) {
            $academicFee->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
