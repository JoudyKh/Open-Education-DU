<?php

namespace App\Services\Admin\City;
use App\Http\Requests\Api\Admin\City\CreateCityRequest;
use App\Http\Requests\Api\Admin\City\UpdateCityRequest;
use App\Http\Resources\CityResource;
use App\Models\City;

class CityService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function store(CreateCityRequest $request)
    {
        $data = $request->validated();
        $city = City::create($data);
        return CityResource::make($city);
    }
    public function update(UpdateCityRequest $request, City $city)
    {
        $data = $request->validated();
        $city->update($data);
        $city = City::find($city->id);
        return CityResource::make($city);
    }
}
