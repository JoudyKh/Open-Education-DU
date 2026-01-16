<?php

namespace App\Http\Controllers\Api\General\Curriculum;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurriculumResource;
use App\Models\Curriculum;
use App\Services\General\Curriculum\CurriculumService;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function __construct(protected CurriculumService $curriculumService)
    {}
     /**
     * @OA\Get(
     *     path="/curriculums",
     *     tags={"App" , "App - Curriculum"},
     *     summary="get all curriculums",
     *    @OA\Parameter(
     *         name="locale",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"en", "ar"}
     *         ),
     *         description="The locale of the response"
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
     *     @OA\Parameter(
     *         name="paginate",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             enum={"0", "1"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CurriculumResource")
     *     )
     * )
     * @OA\Get(
     *     path="/admin/curriculums",
     *     tags={"Admin" , "Admin - Curriculum"},
     *     summary="get all curriculums",
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
     *     @OA\Parameter(
     *         name="semester_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="get semester curriculums"
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="paginate",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             enum={"0", "1"}
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="student_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CurriculumResource")
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            return success($this->curriculumService->index($request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Get(
     *     path="/curriculums/{id}",
     *     tags={"App" , "App - Curriculum"},
     *     summary="show one curriculum",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *         name="locale",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"en", "ar"}
     *         ),
     *         description="The locale of the response"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CurriculumResource")
     *     )
     * )
     * @OA\Get(
     *     path="/admin/curriculums/{id}",
     *     tags={"Admin" , "Admin - Curriculum"},
     *     summary="show one curriculum",
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
     *         @OA\JsonContent(ref="#/components/schemas/CurriculumResource")
     *     )
     * )
     */
    public function show(Curriculum $curriculum)
    {
        try {
            return success($this->curriculumService->show($curriculum));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
