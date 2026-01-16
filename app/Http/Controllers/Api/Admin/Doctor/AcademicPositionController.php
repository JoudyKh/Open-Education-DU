<?php

namespace App\Http\Controllers\Api\Admin\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Doctor\AcademicPosition\CreateDoctorAcademicPositionRequest;
use App\Http\Requests\Api\Admin\Doctor\AcademicPosition\UpdateDoctorAcademicPositionRequest;
use App\Models\Doctor;
use App\Models\DoctorAcademicPosition;
use App\Services\Admin\Doctor\AcademicPositionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AcademicPositionController extends Controller
{
    public function __construct(protected AcademicPositionService $academicPositionService)
    {}
      /**
     * @OA\Get(
     *     path="/admin/doctors/{doctor}/academic-positions",
     *     tags={"Admin" , "Admin - Doctor - AcademicPosition"},
     *     summary="get all doctor academic positions",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="doctor",
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
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAcademicPositionResource")
     *     )
     * )
     */
    public function index(Doctor $doctor, Request $request)
    {
        try {
            return success($this->academicPositionService->index($doctor, $request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/doctors/{doctor}/academic-positions",
     *     tags={"Admin" , "Admin - Doctor - AcademicPosition"},
     *     summary="Create a new doctor academic position",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="doctor",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateDoctorAcademicPositionRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAcademicPositionResource")
     *     )
     * )
     */
    public function store(Doctor $doctor, CreateDoctorAcademicPositionRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data = $this->academicPositionService->store($doctor, $data);
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
     *     path="/admin/doctors/{doctor}/academic-positions/{academicPosition}",
     *     tags={"Admin" , "Admin - Doctor - AcademicPosition"},
     *     summary="show a doctor academic position",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="doctor",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="academicPosition",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAcademicPositionResource")
     *     )
     * )
     */
    public function show(Doctor $doctor, DoctorAcademicPosition $academicPosition)
    {
        try {
            return success($this->academicPositionService->show($doctor, $academicPosition));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/doctors/{doctor}/academic-positions/{id}",
     *     tags={"Admin" , "Admin - Doctor - AcademicPosition"},
     *     summary="update an existing doctor academinc position",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="doctor",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateDoctorAcademicPositionRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAcademicPositionResource")
     *     )
     * )
     */
    public function update(Doctor $doctor, UpdateDoctorAcademicPositionRequest $request, DoctorAcademicPosition $academicPosition)
    {
        DB::beginTransaction();
    
        try {
            $data = $this->academicPositionService->update($doctor, $request, $academicPosition);
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
     *     path="/admin/doctors/{doctor}/academic-positions/{id}",
     *     tags={"Admin" , "Admin - Doctor - AcademicPosition"},
     *     summary="SoftDelete an existing doctor academic position",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="doctor",
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
     *     path="/admin/doctors/{doctor}/academic-positions/{id}/force",
     *     tags={"Admin" , "Admin - Doctor - AcademicPosition"},
     *     summary="ForceDelete an existing doctor academic position",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="doctor",
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
    public function destroy(Doctor $doctor,$academicPosition, $force = null)
    {
        try {
            return success($this->academicPositionService->destroy($doctor, $academicPosition, $force));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/doctors/{doctor}/academic-positions/{id}/restore",
     *     tags={"Admin", "Admin - Doctor - AcademicPosition"},
     *     summary="Restore a soft-deleted doctor academic position",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="doctor",
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
    public function restore(Doctor $doctor,$academicPosition)
    {
        try {
            return success($this->academicPositionService->restore($doctor, $academicPosition));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
