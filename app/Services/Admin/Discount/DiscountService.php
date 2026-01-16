<?php

namespace App\Services\Admin\Discount;
use App\Http\Requests\Api\Admin\Discount\CreateDiscountRequest;
use App\Http\Requests\Api\Admin\Discount\UpdateDiscountRequest;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use App\Models\Semester;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;

class DiscountService
{
    /**
     * Create a new class instance.
     */
    use SearchTrait;
    public function index(Semester $semester, Request $request)
    {
        $discounts = $semester->discounts();
        $discounts = $discounts->orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($discounts, $request, Discount::$searchable);
        $discounts = $discounts->paginate(config('app.pagination_limit'));
        return DiscountResource::collection($discounts);
    }
    public function store(Semester $semester, CreateDiscountRequest $request)
    {
        $data = $request->validated();
        $semester->discounts()->createMany($data['discounts']);
        return DiscountResource::make($semester->discounts);
    }
    public function show(Semester $semester, Discount $discount)
    {
        return DiscountResource::make($discount);
    }
    public function update(Semester $semester, UpdateDiscountRequest $request, Discount $discount)
    {
        $data = $request->validated();
        $discount->update($data);
        $discount = Discount::find($discount->id);
        return DiscountResource::make($discount);
    }
    public function destroy(Semester $semester, $discount, $force = null)
    {
        if ($force) {
            $discount = Discount::onlyTrashed()->findOrFail($discount);
            $discount->forceDelete();
        } else {
            $discount = Discount::where('id', $discount)->first();
            $discount->delete();
        }
        return true;
    }
    public function restore(Semester $semester, $discount)
    {
        $discount = Discount::withTrashed()->find($discount);
        if ($discount && $discount->trashed()) {
            $discount->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
