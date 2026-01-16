<?php

namespace App\Services\Admin\Nationality;
use App\Http\Requests\Api\Admin\Nationality\CreateNationalityRequest;
use App\Http\Requests\Api\Admin\Nationality\UpdateNationalityRequest;
use App\Models\Nationality;

class NationalityService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function store(CreateNationalityRequest $request)
    {
        $data = $request->validated();
        $nationality = Nationality::create($data);
        return $nationality;
    }
    public function update(UpdateNationalityRequest $request, Nationality $nationality)
    {
        $data = $request->validated();
        $nationality->update($data);
        $nationality = Nationality::find($nationality->id);
        return $nationality;
    }
}
