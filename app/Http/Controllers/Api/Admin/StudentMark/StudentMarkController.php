<?php

namespace App\Http\Controllers\Api\Admin\StudentMark;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\StudentMark\CreateStudentMarkRequest;
use App\Http\Requests\Api\Admin\StudentMark\UpdateSMarkRequest;
use App\Models\Curriculum;
use App\Models\Student;
use App\Models\StudentMark;
use App\Services\Admin\StudentMark\StudentMarkService;
use Illuminate\Http\Request;
use App\Exports\StudentMarkExport;
use Maatwebsite\Excel\Facades\Excel;
class StudentMarkController extends Controller
{
    public function __construct(protected StudentMarkService $studentMarkService)
    {
    }
    /**
     * @OA\Get(
     *     path="/admin/student-marks",
     *     tags={"Admin" , "Admin - StudentMark"},
     *     summary="get all studentMarks",
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
     *             example=""
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="curriculum_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example=""
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StudentMarkResource")
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            return success($this->studentMarkService->index($request));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/student-marks/import",
     *     tags={"Admin" , "Admin - StudentMark"},
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
    public function importExcel(Request $request)
    {
        try {
            return success($this->studentMarkService->importExcel($request));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }

    }
    /**
     * @OA\Get(
     *     path="/admin/student-marks/{id}/export-excel",
     *     tags={"Admin" , "Admin - StudentMark"},
     *     summary="get a xlsx file",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *        @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *     )
     * )
     */
    public function exportExcel(string $id)
    {
        try {
            $locale = app()->getLocale();
             $curriculum = Curriculum::findOrFail($id);  
             $fileName = $curriculum->{'name_' . $locale} . '-students-marks.xlsx';  
    
            return Excel::download(new StudentMarkExport($id), $fileName);
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
        
    }
        /**
     * @OA\Get(
     *     path="/admin/student-marks/{id}/export-pdf",
     *     tags={"Admin" , "Admin - StudentMark"},
     *     summary="get a pdf file",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *        @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *     )
     * )
     */
    public function exportPdf(string $id)
    {
        try {
            return $this->studentMarkService->exportPdf($id);
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }

    }
    /**
     * @OA\Post(
     *     path="/admin/student-marks",
     *     tags={"Admin" , "Admin - StudentMark"},
     *     summary="Create a new studentMark",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateStudentMarkRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StudentMarkResource")
     *     )
     * )
     */
    public function store(CreateStudentMarkRequest $request)
    {

        try {
            return success($this->studentMarkService->store($request), 201);

        } catch (\Throwable $th) {
            return error($th->getMessage(), [$th->getMessage()], $th->getCode());
        }
    }
    /**
     * @OA\Get(
     *     path="/admin/student-marks/{studentMark}",
     *     tags={"Admin" , "Admin - StudentMark"},
     *     summary="show a studentMark",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *    @OA\Parameter(
     *         name="studentMark",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StudentMarkResource")
     *     )
     * )
     */
    public function show(StudentMark $studentMark)
    {
        try {
            return success($this->studentMarkService->show($studentMark));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/student-marks/{id}",
     *     tags={"Admin" , "Admin - StudentMark"},
     *     summary="update an existing studentMark",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateStudentMarkRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/StudentMarkResource")
     *     )
     * )
     */
    public function update(UpdateSMarkRequest $request, StudentMark $studentMark)
    {
        try {
            return success($this->studentMarkService->update($request, $studentMark));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Delete(
     *     path="/admin/student-marks/{id}",
     *     tags={"Admin" , "Admin - StudentMark"},
     *     summary="SoftDelete an existing studentMark",
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
     *     path="/admin/student-marks/{id}/force",
     *     tags={"Admin" , "Admin - StudentMark"},
     *     summary="ForceDelete an existing studentMark",
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
    public function destroy($studentMark, $force = null)
    {
        try {
            return success($this->studentMarkService->destroy($studentMark, $force));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Get(
     *     path="/admin/student-marks/{id}/restore",
     *     tags={"Admin", "Admin - StudentMark"},
     *     summary="Restore a soft-deleted studentMark",
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
    public function restore($studentMark)
    {
        try {
            return success($this->studentMarkService->restore($studentMark));
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
