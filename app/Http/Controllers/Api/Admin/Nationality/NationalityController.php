<?php

namespace App\Http\Controllers\Api\Admin\Nationality;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Nationality\CreateNationalityRequest;
use App\Http\Requests\Api\Admin\Nationality\UpdateNationalityRequest;
use App\Models\Nationality;
use App\Services\Admin\Nationality\NationalityService;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    public function __construct(protected NationalityService $nationalityService)
    {
    }
    /**
     * @OA\Post(
     *     path="/admin/nationalities",
     *     tags={"Admin" , "Admin - Nationality"},
     *     summary="Create a new nationality",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateNationalityRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *     )
     * )
     */
    public function store(CreateNationalityRequest $request)
    {
        try {
            return success($this->nationalityService->store($request));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/nationalities/{id}",
     *     tags={"Admin" , "Admin - Nationality"},
     *     summary="update an existing nationality",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateNationalityRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     )
     * )
     */
    public function update(UpdateNationalityRequest $request, Nationality $nationality)
    {
        try {
            return success($this->nationalityService->update($request, $nationality));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Delete(
     *     path="/admin/nationalities/{id}",
     *     tags={"Admin" , "Admin - Nationality"},
     *     summary="delete an existing nationality",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *     )
     * )
     */
    public function destroy(Nationality $nationality)
    {
        try {
            $nationality->deleteOrFail();
            return success();
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
