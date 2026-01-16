<?php

namespace App\Http\Requests\Api\Admin\Discount;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="CreateDiscountRequest",  
 *     type="object",   
 *     @OA\Property(property="discounts[0][name]", type="string", example="dis"),  
 *     @OA\Property(property="discounts[0][percentage]", type="number", format="double", example=50),  
 *     @OA\Property(property="discounts[0][is_exhausted_student]", type="boolean", enum={"0", "1"})  
 * )  
 */  

class CreateDiscountRequest extends FormRequest
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
            'discounts' => 'required|array',
            'discounts.*.name' => 'required|string|max:255',
            'discounts.*.percentage' => 'required|numeric',
            'discounts.*.is_exhausted_student' => 'required|boolean',
        ];
    }
}
