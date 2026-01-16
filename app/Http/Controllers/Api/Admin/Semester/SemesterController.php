<?php

namespace App\Http\Controllers\Api\Admin\Semester;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Semester\AddCurriculumsRequest;
use App\Http\Requests\Api\Admin\Semester\CreateSemesterRequest;
use App\Http\Requests\Api\Admin\Semester\UpdateSemesterRequest;
use App\Http\Resources\SemesterResource;
use App\Models\Log;
use Illuminate\Support\Facades\Cache;

use App\Models\Semester;
use App\Services\Admin\Semester\SemesterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    public function __construct(protected SemesterService $semesterService)
    {
    }

    /**
     * @OA\Post(
     *     path="/admin/semesters",
     *     tags={"Admin" , "Admin - Semester"},
     *     summary="Create a new semester",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateSemesterRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SemesterResource")
     *     )
     * )
     */
    public function store(CreateSemesterRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->semesterService->store($request);
            DB::commit();
            Cache::flush();
            return success($data, 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return error($th->getMessage(), [$th->getMessage()], $th->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/semesters/{id}",
     *     tags={"Admin" , "Admin - Semester"},
     *     summary="update an existing semester",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateSemesterRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SemesterResource")
     *     )
     * )
     */
    public function update(UpdateSemesterRequest $request, Semester $semester)
    {
        DB::beginTransaction();

        try {
            $data = $this->semesterService->update($request, $semester);
            DB::commit();
            Cache::flush();
            return success($data);

        } catch (\Throwable $th) {
            DB::rollBack();
            return error($th->getMessage(), [$th->getMessage()], $th->getCode());
        }
    }
    /**
     * @OA\Delete(
     *     path="/admin/semesters/{id}",
     *     tags={"Admin" , "Admin - Semester"},
     *     summary="SoftDelete an existing semester",
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
     *     path="/admin/semesters/{id}/force",
     *     tags={"Admin" , "Admin - Semester"},
     *     summary="ForceDelete an existing semester",
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
    public function destroy($semester, $force = null)
    {
        DB::beginTransaction();

        try {
            $data = $this->semesterService->destroy($semester, $force);
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
     *     path="/admin/semesters/{id}/restore",
     *     tags={"Admin", "Admin - Semester"},
     *     summary="Restore a soft-deleted semester",
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
    public function restore($semester)
    {
        DB::beginTransaction();

        try {
            $data = $this->semesterService->restore($semester);
            DB::commit();
            Cache::flush();
            return success($data);

        } catch (\Throwable $th) {
            DB::rollBack();
            return error($th->getMessage(), [$th->getMessage()], $th->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/semesters/{id}/add/curriculums",
     *     tags={"Admin" , "Admin - Semester"},
     *     summary="add curriculums for a current semester",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/AddCurriculumsRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     )
     * )
     */
    public function addCurriculums(Semester $semester, AddCurriculumsRequest $request)
    {
        try {
            $data = $request->validated();
            // todo check if will make it unique
            $semester->curriculums()->attach($data['curriculums']);
            Log::create([
                'user_id' => auth()->id(),
                'model_type' => get_class($semester),
                'model_id' => $semester->id,
                'operation' => 'attach_curriculums',
                'request_payload' => json_encode($data['curriculums']),
            ]);
            return success(SemesterResource::make($semester));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }


}
