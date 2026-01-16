<?php

namespace App\Http\Requests\Api\Admin\Employee;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="UpdateEmployeeRequest",  
 *     type="object",  
 *     @OA\Property(property="first_name", type="string", maxLength=255, example="John"),  
 *     @OA\Property(property="last_name", type="string", maxLength=255, example="Doe"),  
 *     @OA\Property(property="father_name", type="string", maxLength=255, example="Richard"),  
 *     @OA\Property(property="mother_name", type="string", maxLength=255, example="Jane"),  
 *     @OA\Property(property="birth_place", type="string", maxLength=255, example="New York"),  
 *     @OA\Property(property="birth_date", type="string", format="date", example="1990-01-01"),  
 *     @OA\Property(property="national_id", type="string", maxLength=255, example="123456789"),  
 *     @OA\Property(property="place_of_registration", type="string", maxLength=255, example="New York"),  
 *     @OA\Property(property="id_front_side_image", type="string", format="binary"),  
 *     @OA\Property(property="id_back_side_image", type="string", format="binary"),  
 *     @OA\Property(property="admin_decision_date", type="string", format="date", example="2024-01-01"),  
 *     @OA\Property(property="admin_decision_number", type="string", maxLength=255, example="m213"),
 *     @OA\Property(property="password", type="string",  example="strongpassword")    
 * )  
 */
class UpdateEmployeeRequest extends FormRequest
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
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'national_id' => 'nullable|string|max:255|unique:employees,national_id,' . $this->route('employee')->id,
            'place_of_registration' => 'nullable|string|max:255',
            'id_front_side_image' => 'nullable|image',
            'id_back_side_image' => 'nullable|image',
            'admin_decision_date' => 'nullable|date',
            'admin_decision_number' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
        ];
    }
}
