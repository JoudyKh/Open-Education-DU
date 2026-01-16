<?php

namespace App\Services\General\Country;
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
    public function index()
    {
        $countries = Country::get();
        return CountryResource::collection($countries); 
    }
}
