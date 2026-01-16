<?php

namespace App\Http\Controllers\Api\Admin\ExaminationDate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ExaminationDate\CreateExaminationDateRequest;
use App\Http\Requests\Api\Admin\ExaminationDate\UpdateExaminationDateRequest;
use App\Models\ExaminationDate;
use App\Models\Semester;
use App\Services\Admin\ExaminationDate\ExaminationDateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ExaminationDateController extends Controller
{
    public function __construct(protected ExaminationDateService $examinationDateService)
    {}
      /**
     * @OA\Get(
     *     path="/admin/semesters/{semester}/examination-dates",
     *     tags={"Admin" , "Admin - ExaminationDate"},
     *     summary="get all examinationDates",
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
     *         @OA\JsonContent(ref="#/components/schemas/ExaminationDateResource")
     *     )
     * )
     */
    public function index(Semester $semester, Request $request)
    {
        try {
            return success($this->examinationDateService->index($semester, $request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/semesters/{semester}/examination-dates",
     *     tags={"Admin" , "Admin - ExaminationDate"},
     *     summary="Create a new examinationDate",
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
     *             @OA\Schema(ref="#/components/schemas/CreateExaminationDateRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ExaminationDateResource")
     *     )
     * )
     */
    public function store(Semester $semester, CreateExaminationDateRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->examinationDateService->store($semester, $request);
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
     *     path="/admin/semesters/{semester}/examination-dates/{examinationDate}",
     *     tags={"Admin" , "Admin - ExaminationDate"},
     *     summary="show a examinationDate",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="examinationDate",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ExaminationDateResource")
     *     )
     * )
     */
    public function show(Semester $semester, ExaminationDate $examinationDate)
    {
        try {
            return success($this->examinationDateService->show($semester, $examinationDate));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Post(
     *     path="/admin/semesters/{semester}/examination-dates/{id}",
     *     tags={"Admin" , "Admin - ExaminationDate"},
     *     summary="update an existing examinationDate",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateExaminationDateRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ExaminationDateResource")
     *     )
     * )
     */
    public function update(Semester $semester, UpdateExaminationDateRequest $request, ExaminationDate $examinationDate)
    {
        try {
            return success($this->examinationDateService->update($semester, $request, $examinationDate));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
      /**
     * @OA\Delete(
     *     path="/admin/semesters/{semester}/examination-dates/{id}",
     *     tags={"Admin" , "Admin - ExaminationDate"},
     *     summary="SoftDelete an existing examinationDate",
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
     *     path="/admin/semesters/{semester}/examination-dates/{id}/force",
     *     tags={"Admin" , "Admin - ExaminationDate"},
     *     summary="ForceDelete an existing examinationDate",
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
    public function destroy(Semester $semester,$examinationDate, $force = null)
    {
        try {
            return success($this->examinationDateService->destroy($semester, $examinationDate, $force));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/semesters/{semester}/examination-dates/{id}/restore",
     *     tags={"Admin", "Admin - ExaminationDate"},
     *     summary="Restore a soft-deleted examinationDate",
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
    public function restore(Semester $semester,$examinationDate)
    {
        try {
            return success($this->examinationDateService->restore($semester, $examinationDate));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
