<?php

namespace App\Http\Controllers\Api\Admin\UniversityServicesFee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\UniversityServicesFee\CreateUniversityServicesFeeRequest;
use App\Http\Requests\Api\Admin\UniversityServicesFee\UpdateUniversityServicesFeeRequest;
use App\Models\Semester;
use App\Models\UniversityServicesFee;
use App\Services\Admin\UniversityServicesFee\UniversityServicesFeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UniversityServicesFeeController extends Controller
{
    public function __construct(protected UniversityServicesFeeService $universityServicesFeeService)
    {}
      /**
     * @OA\Get(
     *     path="/admin/semesters/{semester}/university-services-fees",
     *     tags={"Admin" , "Admin - UniversityServicesFee"},
     *     summary="get all universityServicesFees",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
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
     *         @OA\JsonContent(ref="#/components/schemas/UniversityServicesFeeResource")
     *     )
     * )
     */
    public function index(Semester $semester, Request $request)
    {
        try {
            return success($this->universityServicesFeeService->index($semester, $request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/semesters/{semester}/university-services-fees",
     *     tags={"Admin" , "Admin - UniversityServicesFee"},
     *     summary="Create a new universityServicesFee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateUniversityServicesFeeRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/UniversityServicesFeeResource")
     *     )
     * )
     */
    public function store(Semester $semester, CreateUniversityServicesFeeRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->universityServicesFeeService->store($semester, $request);
            DB::commit();
            Cache::flush();
            return success($data, 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return error($th->getMessage(), [$th->getMessage()], $th->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/semesters/{semester}/university-services-fees/{universityServicesFee}",
     *     tags={"Admin" , "Admin - UniversityServicesFee"},
     *     summary="show a universityServicesFee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="universityServicesFee",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/UniversityServicesFeeResource")
     *     )
     * )
     */
    public function show(Semester $semester, UniversityServicesFee $universityServicesFee)
    {
        try {
            return success($this->universityServicesFeeService->show($semester, $universityServicesFee));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Post(
     *     path="/admin/semesters/{semester}/university-services-fees/{id}",
     *     tags={"Admin" , "Admin - UniversityServicesFee"},
     *     summary="update an existing universityServicesFee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
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
     *             @OA\Schema(ref="#/components/schemas/UpdateUniversityServicesFeeRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/UniversityServicesFeeResource")
     *     )
     * )
     */
    public function update(Semester $semester, UpdateUniversityServicesFeeRequest $request, UniversityServicesFee $universityServicesFee)
    {
        try {
            return success($this->universityServicesFeeService->update($semester, $request, $universityServicesFee));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
      /**
     * @OA\Delete(
     *     path="/admin/semesters/{semester}/university-services-fees/{id}",
     *     tags={"Admin" , "Admin - UniversityServicesFee"},
     *     summary="SoftDelete an existing universityServicesFee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
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
     *     path="/admin/semesters/{semester}/university-services-fees/{id}/force",
     *     tags={"Admin" , "Admin - UniversityServicesFee"},
     *     summary="ForceDelete an existing universityServicesFee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
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
    public function destroy(Semester $semester,$universityServicesFee, $force = null)
    {
        try {
            return success($this->universityServicesFeeService->destroy($semester, $universityServicesFee, $force));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/semesters/{semester}/university-services-fees/{id}/restore",
     *     tags={"Admin", "Admin - UniversityServicesFee"},
     *     summary="Restore a soft-deleted universityServicesFee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
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
    public function restore(Semester $semester,$universityServicesFee)
    {
        try {
            return success($this->universityServicesFeeService->restore($semester, $universityServicesFee));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
