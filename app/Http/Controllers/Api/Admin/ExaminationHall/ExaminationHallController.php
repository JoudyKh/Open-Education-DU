<?php

namespace App\Http\Controllers\Api\Admin\ExaminationHall;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ExaminationHall\CreateExaminationHallRequest;
use App\Http\Requests\Api\Admin\ExaminationHall\UpdateExaminationHallRequest;
use App\Models\ExaminationHall;
use App\Models\Semester;
use App\Services\Admin\ExaminationHall\ExaminationHallService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ExaminationHallController extends Controller
{
    public function __construct(protected ExaminationHallService $examinationHallService)
    {}
      /**
     * @OA\Get(
     *     path="/admin/semesters/{semester}/examination-halls",
     *     tags={"Admin" , "Admin - ExaminationHall"},
     *     summary="get all examinationHalls",
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
     *         @OA\JsonContent(ref="#/components/schemas/ExaminationHallResource")
     *     )
     * )
     */
    public function index(Semester $semester, Request $request)
    {
        try {
            return success($this->examinationHallService->index($semester, $request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/semesters/{semester}/examination-halls",
     *     tags={"Admin" , "Admin - ExaminationHall"},
     *     summary="Create a new examinationHall",
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
     *             @OA\Schema(ref="#/components/schemas/CreateExaminationHallRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ExaminationHallResource")
     *     )
     * )
     */
    public function store(Semester $semester, CreateExaminationHallRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->examinationHallService->store($semester, $request);
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
     *     path="/admin/semesters/{semester}/examination-halls/{examinationHall}",
     *     tags={"Admin" , "Admin - ExaminationHall"},
     *     summary="show a examinationHall",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="examinationHall",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ExaminationHallResource")
     *     )
     * )
     */
    public function show(Semester $semester, ExaminationHall $examinationHall)
    {
        try {
            return success($this->examinationHallService->show($semester, $examinationHall));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Post(
     *     path="/admin/semesters/{semester}/examination-halls/{id}",
     *     tags={"Admin" , "Admin - ExaminationHall"},
     *     summary="update an existing examinationHall",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateExaminationHallRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ExaminationHallResource")
     *     )
     * )
     */
    public function update(Semester $semester, UpdateExaminationHallRequest $request, ExaminationHall $examinationHall)
    {
        try {
            return success($this->examinationHallService->update($semester, $request, $examinationHall));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
      /**
     * @OA\Delete(
     *     path="/admin/semesters/{semester}/examination-halls/{id}",
     *     tags={"Admin" , "Admin - ExaminationHall"},
     *     summary="SoftDelete an existing examinationHall",
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
     *     path="/admin/semesters/{semester}/examination-halls/{id}/force",
     *     tags={"Admin" , "Admin - ExaminationHall"},
     *     summary="ForceDelete an existing examinationHall",
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
    public function destroy(Semester $semester,$examinationHall, $force = null)
    {
        try {
            return success($this->examinationHallService->destroy($semester, $examinationHall, $force));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/semesters/{semester}/examination-halls/{id}/restore",
     *     tags={"Admin", "Admin - ExaminationHall"},
     *     summary="Restore a soft-deleted examinationHall",
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
    public function restore(Semester $semester,$examinationHall)
    {
        try {
            return success($this->examinationHallService->restore($semester, $examinationHall));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
