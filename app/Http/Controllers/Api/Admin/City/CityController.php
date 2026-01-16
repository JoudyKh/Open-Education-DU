<?php

namespace App\Http\Controllers\Api\Admin\City;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\City\CreateCityRequest;
use App\Http\Requests\Api\Admin\City\UpdateCityRequest;
use App\Models\City;
use App\Services\Admin\City\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(protected CityService $cityService)
    {
    }

    /**
     * @OA\Post(
     *     path="/admin/cities",
     *     tags={"Admin" , "Admin - City"},
     *     summary="Create a new city",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateCityRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CityResource")
     *     )
     * )
     */
    public function store(CreateCityRequest $request)
    {
        try {
            return success($this->cityService->store($request), 201);
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/cities/{id}",
     *     tags={"Admin" , "Admin - City"},
     *     summary="update an existing city",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="_method",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"PUT"}, default="PUT")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UpdateCityRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CityResource")
     *     )
     * )
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        try {
            return success($this->cityService->update($request, $city));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Delete(
     *     path="/admin/cities/{id}",
     *     tags={"Admin" , "Admin - City"},
     *     summary="delete an existing city",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy(City $city)
    {
        try {
            $city->deleteOrFail();
            return success();
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
