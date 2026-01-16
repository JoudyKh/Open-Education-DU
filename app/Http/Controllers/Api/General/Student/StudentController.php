<?php

namespace App\Http\Controllers\Api\General\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\General\Student\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(protected StudentService $studentService)
    {}
     /**
     * @OA\Get(
     *     path="/student",
     *     tags={"App" , "App - Auth"},
     *     summary="show student",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StudentResource")
     *     )
     * )
     * @OA\Get(
     *     path="/admin/students/{id}",
     *     tags={"Admin" , "Admin - Student"},
     *     summary="show one student",
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
     *         @OA\JsonContent(ref="#/components/schemas/StudentResource")
     *     )
     * )
     */
    public function show($student = null)
    {
        try {
            return success($this->studentService->show($student));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
