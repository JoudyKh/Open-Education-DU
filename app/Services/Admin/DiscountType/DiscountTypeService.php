<?php

namespace App\Services\Admin\DiscountType;
use App\Http\Requests\Api\Admin\DiscountType\CreateDiscountTypeRequest;
use App\Http\Requests\Api\Admin\DiscountType\UpdateDiscountTypeRequest;
use App\Http\Resources\DiscountTypeResource;
use App\Models\DiscountType;
use App\Models\UniversityServicesFee;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class DiscountTypeService
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
        $discountTypes = DiscountType::orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($discountTypes, $request, DiscountType::$searchable);
        $discountTypes = $discountTypes->paginate(config('app.pagination_limit'));
        return DiscountTypeResource::collection($discountTypes);
    }
    public function store(CreateDiscountTypeRequest $request)
    {
        $data = $request->validated();
        $discountType = DiscountType::create($data);
        return DiscountTypeResource::make($discountType);
    }
    public function show(DiscountType $discountType)
    {
        return DiscountTypeResource::make($discountType);
    }
    public function update(UpdateDiscountTypeRequest $request, DiscountType $discountType)
    {
        $data = $request->validated();
        $discountType->update($data);
        $discountType = DiscountType::find($discountType->id);
        return DiscountTypeResource::make($discountType);
    }
    public function destroy($discountType, $force = null)
    {
        $exist = UniversityServicesFee::withTrashed()->where('discount_type_id', $discountType)->exists();
        if ($exist){
            throw new \Exception(__('messages.can_not_delete_type'), 422);
        }
        if ($force) {
            $discountType = DiscountType::onlyTrashed()->findOrFail($discountType);
            $discountType->forceDelete();
        } else {
            $discountType = DiscountType::where('id', $discountType)->first();
            $discountType->delete();
        }
        return true;
    }
    public function restore($discountType)
    {
        $discountType = DiscountType::withTrashed()->find($discountType);
        if ($discountType && $discountType->trashed()) {
            $discountType->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
