<?php

namespace App\Services\Admin\Province;
use App\Http\Requests\Api\Admin\Province\UpdateProvinceRequest;
use App\Http\Resources\ProvinceResource;
use App\Models\Province;

class ProvinceService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function update(UpdateProvinceRequest $request, Province $province)
    {
        $data = $request->validated();
        if (isset($data['ar_name'])) {
            $data['name']['ar'] = $data['ar_name'];
        }
        if (isset($data['en_name'])) {
            $data['name']['en'] = $data['en_name'];
        }
        $province->update($data);
        $province = Province::find($province->id);
        return ProvinceResource::make($province);
    }
}
