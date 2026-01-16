<?php

namespace App\Http\Controllers\Api\Admin\ProgramRule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ProgramRule\CreateProgramRuleRequest;
use App\Http\Requests\Api\Admin\ProgramRule\UpdateProgramRuleRequest;
use App\Models\ProgramRule;
use App\Services\Admin\ProgramRule\ProgramRuleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProgramRuleController extends Controller
{
    public function __construct(protected ProgramRuleService $programRuleService)
    {}
      /**
     * @OA\Get(
     *     path="/admin/program-rules",
     *     tags={"Admin" , "Admin - ProgramRule"},
     *     summary="get all programRules",
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
     *         @OA\JsonContent(ref="#/components/schemas/ProgramRuleResource")
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            return success($this->programRuleService->index($request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/program-rules",
     *     tags={"Admin" , "Admin - ProgramRule"},
     *     summary="Create a new programRule",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateProgramRuleRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ProgramRuleResource")
     *     )
     * )
     */
    public function store(CreateProgramRuleRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->programRuleService->store($request);
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
     *     path="/admin/program-rules/{programRule}",
     *     tags={"Admin" , "Admin - ProgramRule"},
     *     summary="show a programRule",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="programRule",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ProgramRuleResource")
     *     )
     * )
     */
    public function show(ProgramRule $programRule)
    {
        try {
            return success($this->programRuleService->show($programRule));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Post(
     *     path="/admin/program-rules/{id}",
     *     tags={"Admin" , "Admin - ProgramRule"},
     *     summary="update an existing programRule",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateProgramRuleRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ProgramRuleResource")
     *     )
     * )
     */
    public function update(UpdateProgramRuleRequest $request, ProgramRule $programRule)
    {
        try {
            return success($this->programRuleService->update($request, $programRule));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
      /**
     * @OA\Delete(
     *     path="/admin/program-rules/{id}",
     *     tags={"Admin" , "Admin - ProgramRule"},
     *     summary="SoftDelete an existing programRule",
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
     *     path="/admin/program-rules/{id}/force",
     *     tags={"Admin" , "Admin - ProgramRule"},
     *     summary="ForceDelete an existing programRule",
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
    public function destroy($programRule, $force = null)
    {
        try {
            return success($this->programRuleService->destroy($programRule, $force));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/program-rules/{id}/restore",
     *     tags={"Admin", "Admin - ProgramRule"},
     *     summary="Restore a soft-deleted programRule",
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
    public function restore($programRule)
    {
        try {
            return success($this->programRuleService->restore($programRule));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
