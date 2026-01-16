<?php

namespace App\Http\Controllers\Api\Admin\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Doctor\AcademicInfo\CreateDoctorAcademicInfoRequest;
use App\Http\Requests\Api\Admin\Doctor\AcademicInfo\UpdateDoctorAcademicInfoRequest;
use App\Models\Doctor;
use App\Models\DoctorAcademicInfo;
use App\Services\Admin\Doctor\AcademicInfoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AcademicInfoController extends Controller
{
    public function __construct(protected AcademicInfoService $academicInfoService)
    {}
      /**
     * @OA\Get(
     *     path="/admin/doctors/{doctor}/academic-infos",
     *     tags={"Admin" , "Admin - Doctor - AcademicInfo"},
     *     summary="get all doctor academic infos",
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
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAcademicInfoResource")
     *     )
     * )
     */
    public function index(Doctor $doctor, Request $request)
    {
        try {
            return success($this->academicInfoService->index($doctor, $request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/doctors/{doctor}/academic-infos",
     *     tags={"Admin" , "Admin - Doctor - AcademicInfo"},
     *     summary="Create a new doctor academic infos",
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
     *             @OA\Schema(ref="#/components/schemas/CreateDoctorAcademicInfoRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAcademicInfoResource")
     *     )
     * )
     */
    public function store(Doctor $doctor, CreateDoctorAcademicInfoRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data = $this->academicInfoService->store($doctor, $data);
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
     *     path="/admin/doctors/{doctor}/academic-infos/{academicInfo}",
     *     tags={"Admin" , "Admin - Doctor - AcademicInfo"},
     *     summary="show a doctor academic infos",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="doctor",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="academicInfo",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAcademicInfoResource")
     *     )
     * )
     */
    public function show(Doctor $doctor, DoctorAcademicInfo $academicInfo)
    {
        try {
            return success($this->academicInfoService->show($doctor, $academicInfo));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Post(
     *     path="/admin/doctors/{doctor}/academic-infos/{id}",
     *     tags={"Admin" , "Admin - Doctor - AcademicInfo"},
     *     summary="update an existing doctor academinc infos",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateDoctorAcademicInfoRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAcademicInfoResource")
     *     )
     * )
     */
    public function update(Doctor $doctor, UpdateDoctorAcademicInfoRequest $request, DoctorAcademicInfo $academicInfo)
    {
        DB::beginTransaction();
    
        try {
            $data = $this->academicInfoService->update($doctor, $request, $academicInfo);
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
     *     path="/admin/doctors/{doctor}/academic-infos/{id}",
     *     tags={"Admin" , "Admin - Doctor - AcademicInfo"},
     *     summary="SoftDelete an existing doctor academic infos",
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
     *     path="/admin/doctors/{doctor}/academic-infos/{id}/force",
     *     tags={"Admin" , "Admin - Doctor - AcademicInfo"},
     *     summary="ForceDelete an existing doctor academic infos",
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
    public function destroy(Doctor $doctor,$academicInfo, $force = null)
    {
        try {
            return success($this->academicInfoService->destroy($doctor, $academicInfo, $force));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/doctors/{doctor}/academic-infos/{id}/restore",
     *     tags={"Admin", "Admin - Doctor - AcademicInfo"},
     *     summary="Restore a soft-deleted doctor academic infos",
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
    public function restore(Doctor $doctor,$academicInfo)
    {
        try {
            return success($this->academicInfoService->restore($doctor, $academicInfo));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
