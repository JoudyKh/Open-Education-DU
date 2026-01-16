<?php

namespace App\Http\Controllers\Api\Admin\Curriculum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Curriculum\CreateCurriculumRequest;
use App\Http\Requests\Api\Admin\Curriculum\UpdateCurriculumRequest;
use App\Http\Resources\CurriculumResource;
use App\Models\Curriculum;
use App\Services\Admin\Curriculum\CurriculumService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CurriculumController extends Controller
{
    public function __construct(protected CurriculumService $curriculumService)
    {}
    
    /**
     * @OA\Post(
     *     path="/admin/curriculums",
     *     tags={"Admin" , "Admin - Curriculum"},
     *     summary="Create a new curriculum",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateCurriculumRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CurriculumResource")
     *     )
     * )
     */
    public function store(CreateCurriculumRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->curriculumService->store($request);
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
     *     path="/admin/curriculums/{id}",
     *     tags={"Admin" , "Admin - Curriculum"},
     *     summary="update an existing curriculum",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateCurriculumRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CurriculumResource")
     *     )
     * )
     */
    public function update(UpdateCurriculumRequest $request, Curriculum $curriculum)
    {
        DB::beginTransaction();

        try {
            $data = $this->curriculumService->update($request, $curriculum);
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
     *     path="/admin/curriculums/{id}",
     *     tags={"Admin" , "Admin - Curriculum"},
     *     summary="SoftDelete an existing curriculum",
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
     *     path="/admin/curriculums/{id}/force",
     *     tags={"Admin" , "Admin - Curriculum"},
     *     summary="ForceDelete an existing curriculum",
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
    public function destroy($curriculum, $force = null)
    {
        DB::beginTransaction();

        try {
            $data = $this->curriculumService->destroy($curriculum, $force);
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
     *     path="/admin/curriculums/{id}/restore",
     *     tags={"Admin", "Admin - Curriculum"},
     *     summary="Restore a soft-deleted curriculum",
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
    public function restore($curriculum)
    {
        try {
            return success($this->curriculumService->restore($curriculum));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
