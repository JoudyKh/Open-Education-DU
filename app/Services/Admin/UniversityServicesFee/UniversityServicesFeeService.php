<?php

namespace App\Services\Admin\UniversityServicesFee;
use App\Http\Requests\Api\Admin\UniversityServicesFee\CreateUniversityServicesFeeRequest;
use App\Http\Requests\Api\Admin\UniversityServicesFee\UpdateUniversityServicesFeeRequest;
use App\Http\Resources\UniversityServicesFeeResource;
use App\Models\Semester;
use App\Models\UniversityServicesFee;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class UniversityServicesFeeService
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
        $universityServicesFees = $semester->universityServicesFees();
        $universityServicesFees = $universityServicesFees->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($universityServicesFees, $request, UniversityServicesFee::$searchable);
        $universityServicesFees = $universityServicesFees->paginate(config('app.pagination_limit'));
        return UniversityServicesFeeResource::collection($universityServicesFees);
    }
    public function store(Semester $semester, CreateUniversityServicesFeeRequest $request)
    {
        $data = $request->validated();
        $universityServicesFee = $semester->universityServicesFees()->createMany($data['fees']);
        return UniversityServicesFeeResource::make($universityServicesFee);
    }
    public function show(Semester $semester, UniversityServicesFee $universityServicesFee)
    {
        return UniversityServicesFeeResource::make($universityServicesFee);
    }
    public function update(Semester $semester, UpdateUniversityServicesFeeRequest $request, UniversityServicesFee $universityServicesFee)
    {
        $data = $request->validated();
        $universityServicesFee->update($data);
        $universityServicesFee = UniversityServicesFee::find($universityServicesFee->id);
        return UniversityServicesFeeResource::make($universityServicesFee);
    }
    public function destroy(Semester $semester, $universityServicesFee, $force = null)
    {
        if ($force) {
            $universityServicesFee = UniversityServicesFee::onlyTrashed()->findOrFail($universityServicesFee);
            $universityServicesFee->forceDelete();
        } else {
            $universityServicesFee = UniversityServicesFee::where('id', $universityServicesFee)->first();
            $universityServicesFee->delete();
        }
        return true;
    }
    public function restore(Semester $semester, $universityServicesFee)
    {
        $universityServicesFee = UniversityServicesFee::withTrashed()->find($universityServicesFee);
        if ($universityServicesFee && $universityServicesFee->trashed()) {
            $universityServicesFee->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
