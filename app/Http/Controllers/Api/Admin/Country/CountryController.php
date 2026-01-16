<?php

namespace App\Http\Controllers\Api\Admin\Country;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Country\CreateCountryRequest;
use App\Http\Requests\Api\Admin\Country\UpdateCountryRequest;
use App\Models\Country;
use App\Services\Admin\Country\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(protected CountryService $countryService)
    {
    }

    /**
     * @OA\Post(
     *     path="/admin/countries",
     *     tags={"Admin" , "Admin - Country"},
     *     summary="Create a new country",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateCountryRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CountryResource")
     *     )
     * )
     */
    public function store(CreateCountryRequest $request)
    {
        try {
            return success($this->countryService->store($request), 201);
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/countries/{id}",
     *     tags={"Admin" , "Admin - Country"},
     *     summary="update an existing country",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateCountryRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CountryResource")
     *     )
     * )
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        try {
            return success($this->countryService->update($request, $country));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Delete(
     *     path="/admin/countries/{id}",
     *     tags={"Admin" , "Admin - Country"},
     *     summary="delete an existing country with all its cities",
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
    public function destroy(Country $country)
    {
        try {
            $country->deleteOrFail();
            return success();
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
