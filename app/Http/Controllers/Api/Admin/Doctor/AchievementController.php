<?php

namespace App\Http\Controllers\Api\Admin\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Doctor\Achievement\CreateDoctorAchievementRequest;
use App\Http\Requests\Api\Admin\Doctor\Achievement\UpdateDoctorAchievementRequest;
use App\Models\Doctor;
use App\Models\DoctorAchievement;
use App\Services\Admin\Doctor\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AchievementController extends Controller
{
    public function __construct(protected AchievementService $achievementService)
    {}
      /**
     * @OA\Get(
     *     path="/admin/doctors/{doctor}/achievements",
     *     tags={"Admin" , "Admin - Doctor - Achievement"},
     *     summary="get all doctor academic achievements",
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
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAchievementResource")
     *     )
     * )
     */
    public function index(Doctor $doctor, Request $request)
    {
        try {
            return success($this->achievementService->index($doctor, $request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/doctors/{doctor}/achievements",
     *     tags={"Admin" , "Admin - Doctor - Achievement"},
     *     summary="Create a new doctor achievement",
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
     *             @OA\Schema(ref="#/components/schemas/CreateDoctorAchievementRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAchievementResource")
     *     )
     * )
     */
    public function store(Doctor $doctor, CreateDoctorAchievementRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data = $this->achievementService->store($doctor, $data);
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
     *     path="/admin/doctors/{doctor}/achievements/{achievement}",
     *     tags={"Admin" , "Admin - Doctor - Achievement"},
     *     summary="show a doctor achievement",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="doctor",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="achievement",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAchievementResource")
     *     )
     * )
     */
    public function show(Doctor $doctor, DoctorAchievement $achievement)
    {
        try {
            return success($this->achievementService->show($doctor, $achievement));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/doctors/{doctor}/achievements/{id}",
     *     tags={"Admin" , "Admin - Doctor - Achievement"},
     *     summary="update an existing doctor achievement",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateDoctorAchievementRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorAchievementResource")
     *     )
     * )
     */
    public function update(Doctor $doctor, UpdateDoctorAchievementRequest $request, DoctorAchievement $achievement)
    {
        DB::beginTransaction();
    
        try {
            $data = $this->achievementService->update($doctor, $request, $achievement);
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
     *     path="/admin/doctors/{doctor}/achievements/{id}",
     *     tags={"Admin" , "Admin - Doctor - Achievement"},
     *     summary="SoftDelete an existing doctor achievement",
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
     *     path="/admin/doctors/{doctor}/achievements/{id}/force",
     *     tags={"Admin" , "Admin - Doctor - Achievement"},
     *     summary="ForceDelete an existing doctor achievement",
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
    public function destroy(Doctor $doctor,$achievement, $force = null)
    {
        try {
            return success($this->achievementService->destroy($doctor, $achievement, $force));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/doctors/{doctor}/achievements/{id}/restore",
     *     tags={"Admin", "Admin - Doctor - Achievement"},
     *     summary="Restore a soft-deleted doctor achievement",
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
    public function restore(Doctor $doctor,$achievement)
    {
        try {
            return success($this->achievementService->restore($doctor, $achievement));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
