<?php

namespace App\Services\Admin\Country;
use App\Http\Requests\Api\Admin\Country\CreateCountryRequest;
use App\Http\Requests\Api\Admin\Country\UpdateCountryRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;

class CountryService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function store(CreateCountryRequest $request)
    {
        $data = $request->validated();
        $country = Country::create($data);
        return CountryResource::make($country);
    }
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $data = $request->validated();
        $country->update($data);
        $country = Country::find($country->id);
        return CountryResource::make($country);
    }
}
