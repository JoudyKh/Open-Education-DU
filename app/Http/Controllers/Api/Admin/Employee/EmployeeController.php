<?php

namespace App\Http\Controllers\Api\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Employee\CreateEmployeeRequest;
use App\Http\Requests\Api\Admin\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\Admin\Employee\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeService $employeeService)
    {}
    /**
     * @OA\Get(
     *     path="/admin/employees",
     *     tags={"Admin" , "Admin - Employee"},
     *     summary="get all employees",
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
     *         @OA\JsonContent(ref="#/components/schemas/EmployeeResource")
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            return success($this->employeeService->index($request));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
     /**
     * @OA\Get(
     *     path="/admin/employees/{id}",
     *     tags={"Admin" , "Admin - Employee"},
     *     summary="show one employee",
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
     *         @OA\JsonContent(ref="#/components/schemas/EmployeeResource")
     *     )
     * )
     */
    public function show(Employee $employee)
    {
        try {
            return success($this->employeeService->show($employee));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/admin/employees",
     *     tags={"Admin" , "Admin - Employee"},
     *     summary="Create a new employee",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/CreateEmployeeRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/EmployeeResource")
     *     )
     * )
     */
    public function store(CreateEmployeeRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->employeeService->store($request);
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
     *     path="/admin/employees/{id}",
     *     tags={"Admin" , "Admin - Employee"},
     *     summary="update an existing employee",
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
     *             @OA\Schema(ref="#/components/schemas/UpdateEmployeeRequest") ,
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/EmployeeResource")
     *     )
     * )
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        DB::beginTransaction();

        try {
            $data = $this->employeeService->update($request, $employee);
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
     *     path="/admin/employees/{id}",
     *     tags={"Admin" , "Admin - Employee"},
     *     summary="SoftDelete an existing employee",
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
     *     path="/admin/employees/{id}/force",
     *     tags={"Admin" , "Admin - Employee"},
     *     summary="ForceDelete an existing employee",
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
    public function destroy($employee, $force = null)
    {
        DB::beginTransaction();

        try {
            $data = $this->employeeService->destroy($employee, $force);
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
     *     path="/admin/employees/{id}/restore",
     *     tags={"Admin", "Admin - Employee"},
     *     summary="Restore a soft-deleted employee",
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
    public function restore($employee)
    {
        try {
            return success($this->employeeService->restore($employee));
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
