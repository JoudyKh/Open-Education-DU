<?php

namespace App\Http\Requests\Api\Admin\Discount;

use Illuminate\Foundation\Http\FormRequest;
/**  
 * @OA\Schema(  
 *     schema="UpdateDiscountRequest",  
 *     type="object",    
 *     @OA\Property(property="name", type="string", example="dis"),  
 *     @OA\Property(property="percentage", type="number", format="double", example=50),  
 *     @OA\Property(property="is_exhausted_student", type="boolean", enum={"0", "1"})  
 * )  
 */  
class UpdateDiscountRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'percentage' => 'nullable|numeric',
            'is_exhausted_student' => 'nullable|boolean',
        ];
    }
}
