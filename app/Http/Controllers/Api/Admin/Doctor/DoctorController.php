<?php

namespace App\Http\Controllers\Api\Admin\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Doctor\CreateDoctorRequest;
use App\Http\Requests\Api\Admin\Doctor\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Services\Admin\Doctor\DoctorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function __construct(protected DoctorService $doctorService)
    {}
      /**
     * @OA\Get(
     *     path="/admin/doctors",
     *     tags={"Admin" , "Admin - Doctor"},
     *     summary="get all doctors",
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
     *         @OA\JsonContent(ref="#/components/schemas/DoctorResource")
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            return success($this->doctorService->index($request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/doctors",
     *     tags={"Admin" , "Admin - Doctor"},
     *     summary="Create a new doctor",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},

     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateDoctorRequest"),
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorResource")
     *     )
     * )
     */
    public function store(CreateDoctorRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->doctorService->store($request);
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
     *     path="/admin/doctors/{id}",
     *     tags={"Admin" , "Admin - Doctor"},
     *     summary="show a doctor",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorResource")
     *     )
     * )
     */
    public function show(Doctor $doctor)
    {
        try {
            return success($this->doctorService->show($doctor));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/doctors/{id}",
     *     tags={"Admin" , "Admin - Doctor"},
     *     summary="update an existing doctor",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateDoctorRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/DoctorResource")
     *     )
     * )
     */
    public function update(UpdateDoctorRequest  $request, Doctor $doctor)
    {
        DB::beginTransaction();
    
        try {
            $data = $this->doctorService->update($request, $doctor);
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
     *     path="/admin/doctors/{id}",
     *     tags={"Admin" , "Admin - Doctor"},
     *     summary="SoftDelete an existing doctor",
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
     *     path="/admin/doctors/{id}/force",
     *     tags={"Admin" , "Admin - Doctor"},
     *     summary="ForceDelete an existing doctor",
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
    public function destroy($doctor, $force = null)
    {
        try {
            return success($this->doctorService->destroy($doctor, $force));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/doctors/{id}/restore",
     *     tags={"Admin", "Admin - Doctor"},
     *     summary="Restore a soft-deleted doctor",
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
    public function restore($doctor)
    {
        try {
            return success($this->doctorService->restore($doctor));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
