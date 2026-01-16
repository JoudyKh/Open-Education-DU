<?php

namespace App\Http\Controllers\Api\Admin\DiscountType;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\DiscountType\CreateDiscountTypeRequest;
use App\Http\Requests\Api\Admin\DiscountType\UpdateDiscountTypeRequest;
use App\Models\DiscountType;
use App\Services\Admin\DiscountType\DiscountTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DiscountTypeController extends Controller
{
    public function __construct(protected DiscountTypeService $discountTypeService)
    {}
      /**
     * @OA\Get(
     *     path="/admin/discount-types",
     *     tags={"Admin" , "Admin - DiscountType"},
     *     summary="get all discountTypes",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="trash",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             enum={0, 1},
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="any"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="data base column name"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DiscountTypeResource")
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            return success($this->discountTypeService->index($request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/discount-types",
     *     tags={"Admin" , "Admin - DiscountType"},
     *     summary="Create a new discountType",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateDiscountTypeRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DiscountTypeResource")
     *     )
     * )
     */
    public function store(CreateDiscountTypeRequest $request)
    {
        try {
            return success($this->discountTypeService->store($request), 201);
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/discount-types/{discountsType}",
     *     tags={"Admin" , "Admin - DiscountType"},
     *     summary="show a discountType",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="discountsType",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DiscountTypeResource")
     *     )
     * )
     */
    public function show(DiscountType $discountType)
    {
        try {
            return success($this->discountTypeService->show($discountType));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Post(
     *     path="/admin/discount-types/{id}",
     *     tags={"Admin" , "Admin - DiscountType"},
     *     summary="update an existing discountType",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateDiscountTypeRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DiscountTypeResource")
     *     )
     * )
     */
    public function update(UpdateDiscountTypeRequest $request, DiscountType $discountType)
    {
        try {
            return success($this->discountTypeService->update($request, $discountType));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
      /**
     * @OA\Delete(
     *     path="/admin/discount-types/{id}",
     *     tags={"Admin" , "Admin - DiscountType"},
     *     summary="SoftDelete an existing discountType",
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
     * @OA\Delete(
     *     path="/admin/discount-types/{id}/force",
     *     tags={"Admin" , "Admin - DiscountType"},
     *     summary="ForceDelete an existing discountType",
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
    public function destroy($discountType, $force = null)
    {
        DB::beginTransaction();

        try {
            $data = $this->discountTypeService->destroy($discountType, $force);
            DB::commit();
            Cache::flush();
            return success($data);

        } catch (\Throwable $th) {
            DB::rollBack();
            return error($th->getMessage(), [$th->getMessage()], $th->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/discount-types/{id}/restore",
     *     tags={"Admin", "Admin - DiscountType"},
     *     summary="Restore a soft-deleted discountType",
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
    public function restore($discountType)
    {
        try {
            return success($this->discountTypeService->restore($discountType));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
