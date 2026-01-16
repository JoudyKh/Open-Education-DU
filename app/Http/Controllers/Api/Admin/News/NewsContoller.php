<?php

namespace App\Http\Controllers\Api\Admin\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\News\CreateNewsRequest;
use App\Http\Requests\Api\Admin\News\UpdateNewsRequest;
use App\Models\News;
use App\Services\Admin\News\NewsService;
use Illuminate\Http\Request;

class NewsContoller extends Controller
{
    public function __construct(protected NewsService $newsService)
    {}
    /**
     * @OA\Post(
     *     path="/admin/news",
     *     tags={"Admin" , "Admin - News"},
     *     summary="Create a new news",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateNewsRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/NewsResource")
     *     )
     * )
     */
    public function store(CreateNewsRequest $request)
    {
        try {
            return success($this->newsService->store($request), 201);
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Post(
     *     path="/admin/news/{id}",
     *     tags={"Admin" , "Admin - News"},
     *     summary="update an existing news",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateNewsRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/NewsResource")
     *     )
     * )
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        try {
            return success($this->newsService->update($request, $news));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
      /**
     * @OA\Delete(
     *     path="/admin/news/{id}",
     *     tags={"Admin" , "Admin - News"},
     *     summary="SoftDelete an existing news",
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
     *     path="/admin/news/{id}/force",
     *     tags={"Admin" , "Admin - News"},
     *     summary="ForceDelete an existing news",
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
    public function destroy($news, $force = null)
    {
        try {
            return success($this->newsService->destroy($news, $force));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
        /**
     * @OA\Get(
     *     path="/admin/news/{id}/restore",
     *     tags={"Admin", "Admin - News"},
     *     summary="Restore a soft-deleted news",
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
    public function restore($news)
    {
        try {
            return success($this->newsService->restore($news));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
