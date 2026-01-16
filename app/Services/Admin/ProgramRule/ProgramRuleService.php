<?php

namespace App\Services\Admin\ProgramRule;
use App\Http\Requests\Api\Admin\ProgramRule\CreateProgramRuleRequest;
use App\Http\Requests\Api\Admin\ProgramRule\UpdateProgramRuleRequest;
use App\Http\Resources\ProgramRuleResource;
use App\Models\ProgramRule;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class ProgramRuleService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    use SearchTrait;
    public function index(Request $request)
    {
        $programRules = ProgramRule::orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($programRules, $request, ProgramRule::$searchable);
        $programRules = $programRules->paginate(config('app.pagination_limit'));
        return ProgramRuleResource::collection($programRules);
    }
    public function store(CreateProgramRuleRequest $request)
    {
        $data = $request->validated();
        $programRule = ProgramRule::create($data);
        return ProgramRuleResource::make($programRule);
    }
    public function show(ProgramRule $programRule)
    {
        return ProgramRuleResource::make($programRule);
    }
    public function update(UpdateProgramRuleRequest $request, ProgramRule $programRule)
    {
        $data = $request->validated();
        $programRule->update($data);
        return ProgramRuleResource::make($programRule);
    }
    public function destroy($programRule, $force = null)
    {
        if ($force) {
            $programRule = ProgramRule::onlyTrashed()->findOrFail($programRule);
            $programRule->forceDelete();
        } else {
            $programRule = ProgramRule::where('id', $programRule)->first();
            $programRule->delete();
        }
        return true;
    }
    public function restore($programRule)
    {
        $programRule = ProgramRule::withTrashed()->find($programRule);
        if ($programRule && $programRule->trashed()) {
            $programRule->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
