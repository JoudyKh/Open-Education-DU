<?php

namespace App\Services\General\City;
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
    public function index()
    {
        $cities = City::get();
        return CityResource::collection($cities);
    }
}
