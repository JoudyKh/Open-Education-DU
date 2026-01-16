<?php

namespace App\Services\Admin\Employee;
use App\Constants\Constants;
use App\Http\Requests\Api\Admin\Employee\CreateEmployeeRequest;
use App\Http\Requests\Api\Admin\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeService
{
    /**
     * Create a new class instance.
     */
    use SearchTrait;
    public function index(Request $request)
    {
        $employees = Employee::orderByDesc($request->trash ? 'deleted_at' : 'created_at');
        $this->applySearchAndSort($employees, $request, Employee::$searchable);
        $employees = $employees->paginate(config('app.pagination_limit'));
        return EmployeeResource::collection($employees);
    }
    public function show(Employee $employee)
    {
        return EmployeeResource::make($employee);
    }
    public function store(CreateEmployeeRequest $request)
    {
        $data = $request->validated();

            $data['id_front_side_image'] = $data['id_front_side_image']->storePublicly('employees/images', 'public');
            $data['id_back_side_image'] = $data['id_back_side_image']->storePublicly('employees/images', 'public');
            if(isset($data['password'])){
                $data['password'] = Hash::make($data['password']);
            }
        $employee = Employee::create($data);
        if(isset($data['password'])){
            $employee->assignRole(Constants::EMPLOYEE_ROLE);
        }
        return EmployeeResource::make($employee);
    }
    public function update(UpdateEmployeeRequest $request ,Employee $employee)
    {
        $data = $request->validated();
            
            if (isset($data['id_front_side_image'])) {
                if(Storage::exists("public/$employee->id_front_side_image")){
                    Storage::delete("public/$employee->id_front_side_image");
                }
                $data['id_front_side_image'] = $data['id_front_side_image']->storePublicly('employees/images', 'public');
            }
            if (isset($data['id_back_side_image'])) {
                if(Storage::exists("public/$employee->id_back_side_image")){
                    Storage::delete("public/$employee->id_back_side_image");
                }
                $data['id_back_side_image'] = $data['id_back_side_image']->storePublicly('employees/images', 'public');
            }
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
            $employee->assignRole(Constants::EMPLOYEE_ROLE);
        }
        $employee->update($data);
        $employee = Employee::find($employee->id);
        return EmployeeResource::make($employee);
    }
    public function destroy($employee, $force = null)
    {
        if ($force) {
            $employee = Employee::onlyTrashed()->findOrFail($employee);
            // DB::afterCommit(function() use ($employee){
                if(Storage::exists("public/$employee->id_front_side_image")){
                    Storage::delete("public/$employee->id_front_side_image");
                }
                if(Storage::exists("public/$employee->id_back_side_image")){
                    Storage::delete("public/$employee->id_back_side_image");
                }

            // });
            $employee->forceDelete();
        } else {
            $employee = Employee::where('id', $employee)->first();
            $employee->delete();
        }
        return true;
    }
    public function restore($employee)
    {
        $employee = Employee::withTrashed()->find($employee);
        if ($employee && $employee->trashed()) {
            $employee->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404); 
    }
}
