<?php

namespace App\Http\Controllers\Api\Admin\Province;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Province\UpdateProvinceRequest;
use App\Models\Province;
use App\Services\Admin\Province\ProvinceService;
use Illuminate\Http\Request;

class ProvinceContoller extends Controller
{
    public function __construct(protected ProvinceService $provinceService)
    {}
    /**
     * @OA\Post(
     *     path="/admin/provinces/{id}",
     *     tags={"Admin" , "Admin - Province"},
     *     summary="update an existing province",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="_method",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"PUT"}, default="PUT")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UpdateProvinceRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ProvinceResource")
     *     )
     * )
     */
    public function update(UpdateProvinceRequest $request, Province $province)
    {
        try {
            return success($this->provinceService->update($request, $province), 201);
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
