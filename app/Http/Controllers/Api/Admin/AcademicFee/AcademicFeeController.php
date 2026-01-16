<?php

namespace App\Http\Controllers\Api\Admin\AcademicFee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AcademicFee\CreateAcademicFeeRequest;
use App\Http\Requests\Api\Admin\AcademicFee\UpdateAcademicFeeRequest;
use App\Http\Resources\AcademicFeeResource;
use App\Models\AcademicFee;
use App\Models\Semester;
use App\Services\Admin\AcademicFee\AcademicFeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AcademicFeeController extends Controller
{
    public function __construct(protected AcademicFeeService $academicFeeService)
    {}
      /**
     * @OA\Get(
     *     path="/admin/semesters/{semester}/academic-fees",
     *     tags={"Admin" , "Admin - AcademicFee"},
     *     summary="get all academicFees",
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
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
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
     *         @OA\JsonContent(ref="#/components/schemas/AcademicFeeResource")
     *     )
     * )
     */
    public function index(Semester $semester,Request $request)
    {
        try {
            return success($this->academicFeeService->index($semester, $request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/semesters/{semester}/academic-fees",
     *     tags={"Admin" , "Admin - AcademicFee"},
     *     summary="Create a new academicFee",
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
     *             @OA\Schema(ref="#/components/schemas/CreateAcademicFeeRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/AcademicFeeResource")
     *     )
     * )
     */
    public function store(Semester $semester ,CreateAcademicFeeRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->academicFeeService->store($semester, $request);
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
     *     path="/admin/semesters/{semester}/academic-fees/{academicFee}",
     *     tags={"Admin" , "Admin - AcademicFee"},
     *     summary="show an academicFee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="academicFee",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/AcademicFeeResource")
     *     )
     * )
     */
    public function show(Semester $semester, AcademicFee $academicFee)
    {
        try {
            return success($this->academicFeeService->show($semester, $academicFee));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/semesters/{semester}/academic-fees/{academicFee}",
     *     tags={"Admin" , "Admin - AcademicFee"},
     *     summary="update an academicFee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="academicFee",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateAcademicFeeRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/AcademicFeeResource")
     *     )
     * )
     */
    public function update(Semester $semester, UpdateAcademicFeeRequest $request, AcademicFee $academicFee)
    {
        try {
            return success($this->academicFeeService->update($semester, $request, $academicFee));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
      /**
     * @OA\Delete(
     *     path="/admin/semesters/{semester}/academic-fees/{id}",
     *     tags={"Admin" , "Admin - AcademicFee"},
     *     summary="SoftDelete an existing academicFee",
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
     * @OA\Delete(
     *     path="/admin/semesters/{semester}/academic-fees/{id}/force",
     *     tags={"Admin" , "Admin - AcademicFee"},
     *     summary="ForceDelete an existing academicFee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *      @OA\Parameter(
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
    public function destroy(Semester $semester,$academicFee, $force = null)
    {
        try {
            return success($this->academicFeeService->destroy($semester, $academicFee, $force));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/semesters/{semester}/academic-fees/{id}/restore",
     *     tags={"Admin", "Admin - AcademicFee"},
     *     summary="Restore a soft-deleted academicFee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *      *     @OA\Parameter(
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
    public function restore(Semester $semester,$academicFee)
    {
        try {
            return success($this->academicFeeService->restore($semester, $academicFee));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
