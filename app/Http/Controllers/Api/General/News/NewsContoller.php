<?php

namespace App\Http\Controllers\Api\General\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Services\General\News\NewsService;
use Illuminate\Http\Request;

class NewsContoller extends Controller
{
    public function __construct(protected NewsService $newsService)
    {}
      /**
     * @OA\Get(
     *     path="/news",
     *     tags={"App" , "App - News"},
     *     summary="get all news",
     *    @OA\Parameter(
     *         name="locale",
     *         in="header",
     *         description="Locale of the branch data (optional)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"ar", "en"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/NewsResource")
     *     )
     * )
     * @OA\Get(
     *     path="/admin/news",
     *     tags={"Admin" , "Admin - News"},
     *     summary="get all news",
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
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/NewsResource")
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            return success($this->newsService->index($request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Get(
     *     path="/news/{id}",
     *     tags={"App" , "App - News"},
     *     summary="show one news",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="locale",
     *         in="header",
     *         description="Locale of the branch data (optional)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"ar", "en"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/NewsResource")
     *     )
     * )
     * @OA\Get(
     *     path="/admin/news/{id}",
     *     tags={"Admin" , "Admin - News"},
     *     summary="show one news",
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
     *         @OA\JsonContent(ref="#/components/schemas/NewsResource")
     *     )
     * )
     */
    public function show(News $news)
    {
        try {
            return success($this->newsService->show($news));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
