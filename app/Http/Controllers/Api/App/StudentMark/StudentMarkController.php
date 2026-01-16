<?php

namespace App\Http\Controllers\Api\App\StudentMark;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Services\App\StudentMark\StudentMarkService;
use Illuminate\Http\Request;

class StudentMarkController extends Controller
{
    public function __construct(protected StudentMarkService $studentMarkService)
    {}
      /**
     * @OA\Get(
     *     path="/marks/{semester}",
     *     tags={"App" , "App - Mark"},
     *     summary="get all student marks",
     *     security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="semester",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StudentMarkResource")
     *     )
     * )
     */
    public function index(Semester $semester)
    {
        try{
            return success($this->studentMarkService->index($semester), 200, ['semester' => $semester]);
        }catch(\Exception $e){
            return error($e);
        }
    }
}
