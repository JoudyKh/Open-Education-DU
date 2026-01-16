<?php

namespace App\Services\General\Semester;
use App\Constants\Constants;
use App\Http\Resources\SemesterResource;
use App\Models\Semester;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SemesterService
{
    /**
     * Create a new class instance.
     */
    use SearchTrait;
    public function index(Request $request)
    {
        $semesters = Semester::orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($semesters, $request, Semester::$searchable);
        $semesters = $request->paginate === '0' ? $semesters->get() : $semesters->paginate(config('app.pagination_limit'));
        return SemesterResource::collection($semesters);
    }
    public function show(Semester $semester)
    {
        return SemesterResource::make($semester);
    }
    
}
