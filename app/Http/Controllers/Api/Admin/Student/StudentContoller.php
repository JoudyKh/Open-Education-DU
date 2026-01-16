<?php

namespace App\Http\Controllers\Api\Admin\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Student\CreateStudentRequest;
use App\Http\Requests\Api\Admin\Student\UpdateStudentRequest;
use App\Models\Student;
use App\Services\Admin\Student\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

class StudentContoller extends Controller
{
    public function __construct(protected StudentService $studentService)
    {
    }
    /**
     * @OA\Get(
     *     path="/admin/students",
     *     tags={"Admin" , "Admin - Student"},
     *     summary="get all students",
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
     *         @OA\JsonContent(ref="#/components/schemas/StudentResource")
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            return success($this->studentService->index($request));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/students",
     *     tags={"Admin" , "Admin - Student"},
     *     summary="Create a new student with its contact info and academic info",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateStudentRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StudentResource")
     *     )
     * )
     */
    public function store(CreateStudentRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->studentService->store($request);
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
     *     path="/admin/students/import",
     *     tags={"Admin" , "Admin - Student"},
     *     summary="post a xlsx file",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                  property="excel_file",
     *                  type="string", format="binary",
     *                  example="file.jpg"
     *                  ),
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *     )
     * )
     */
    public function import(Request $request)
    {
        return success($this->studentService->import($request));
    }
    /**
     * @OA\Post(
     *     path="/admin/students/{id}",
     *     tags={"Admin" , "Admin - Student"},
     *     summary="update an existing student with its contact info and academic info",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
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
     *             @OA\Schema(ref="#/components/schemas/UpdateStudentRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StudentResource")
     *     )
     * )
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        DB::beginTransaction();

        try {
            $data = $this->studentService->update($request, $student);
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
     *     path="/admin/students/{id}",
     *     tags={"Admin" , "Admin - Student"},
     *     summary="Softdelete an existing student",
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
     *     path="/admin/students/{id}/force",
     *     tags={"Admin" , "Admin - Student"},
     *     summary="Forcedelete an existing student",
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
    public function destroy($id, $force = null)
    {
        DB::beginTransaction();

        try {
            $data = $this->studentService->destroy($id, $force);
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
     *     path="/admin/students/{id}/restore",
     *     tags={"Admin" , "Admin - Student"},
     *     summary="restore a deleted student",
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
    public function restore($id)
    {
        DB::beginTransaction();

        try {
            DB::commit();
            Cache::flush();
            return success($this->studentService->restore($id));

        } catch (\Throwable $th) {
            DB::rollBack();
            return error($th->getMessage(), [$th->getMessage()], $th->getCode());
        }
    }

}
