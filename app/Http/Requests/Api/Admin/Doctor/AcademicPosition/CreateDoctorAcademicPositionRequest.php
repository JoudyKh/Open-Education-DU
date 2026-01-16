<?php

namespace App\Http\Requests\Api\Admin\Doctor\AcademicPosition;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="CreateDoctorAcademicPositionRequest",  
 *     type="object",  
 *     required={  
 *         "name", "start_year", "end_year",   
 *     },  
 *     @OA\Property(property="name", type="string", example="CS101"),  
 *     @OA\Property(property="start_year", type="string", format="date", example="2023-05-15"),
 *     @OA\Property(property="end_year", type="string", format="date", example="2023-05-15"),
 * )  
 */  
class CreateDoctorAcademicPositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'start_year' => 'required|date_format:Y-m-d',
            'end_year' => 'required|date_format:Y-m-d|after:start_year',
        ];
    }
}
