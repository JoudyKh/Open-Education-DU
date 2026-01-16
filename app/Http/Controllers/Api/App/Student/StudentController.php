<?php

namespace App\Http\Controllers\Api\App\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\App\Student\UpdateStudentRequest;
use App\Services\App\Student\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(protected StudentService $studentService)
    {}
        /**
     * @OA\Post(
     *     path="/student",
     *     tags={"App" , "App - Auth"},
     *     summary="update profile",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="_method",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"PUT"}, default="PUT")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UpdateStudentRequest2") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StudentResource")
     *     )
     * )
     */
    public function update(UpdateStudentRequest $request)
    {
        return success($this->studentService->update($request));
    }
}
