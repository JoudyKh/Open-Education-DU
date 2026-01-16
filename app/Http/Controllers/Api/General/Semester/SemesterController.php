<?php

namespace App\Http\Controllers\Api\General\Semester;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SemesterResource;
use App\Models\Semester;
use App\Services\General\Semester\SemesterService;

class SemesterController extends Controller
{
    public function __construct(protected SemesterService $semesterService)
    {}
     /**
     * @OA\Get(
     *     path="/semesters",
     *     tags={"App" , "App - Semester"},
     *     summary="get all semesters",
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
     *         @OA\JsonContent(ref="#/components/schemas/SemesterResource")
     *     )
     * )
     * @OA\Get(
     *     path="/admin/semesters",
     *     tags={"Admin" , "Admin - Semester"},
     *     summary="get all semesters",
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
     *         @OA\JsonContent(ref="#/components/schemas/SemesterResource")
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            return success($this->semesterService->index($request));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Get(
     *     path="/semesters/{id}",
     *     tags={"App" , "App - Semester"},
     *     summary="show one semester",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SemesterResource")
     *     )
     * )
     * @OA\Get(
     *     path="/admin/semesters/{id}",
     *     tags={"Admin" , "Admin - Semester"},
     *     summary="show one semester",
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
     *         @OA\JsonContent(ref="#/components/schemas/SemesterResource")
     *     )
     * )
     */
    public function show(Semester $semester)
    {
        try {
            return success($this->semesterService->show($semester));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
