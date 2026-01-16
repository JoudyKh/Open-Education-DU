<?php

namespace App\Http\Requests\Api\Admin\UniversityServicesFee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**  
 * @OA\Schema(  
 *     schema="CreateUniversityServicesFeeRequest",  
 *     type="object",  
 *   @OA\Property(
 *         property="fees[0][name]",
 *         type="string",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="fees[0][fee]",
 *         type="double",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="fees[0][discount_percentage]",
 *         type="double",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="fees[0][discount_type_id]",
 *         type="double",
 *         description="discount type ids"
 *     ),   
 * )  
 */
class CreateUniversityServicesFeeRequest extends FormRequest
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
            'fees' => 'required|array',
            'fees.*.name' => 'required|string|max:255',
            'fees.*.fee' => 'required|numeric',
            'fees.*.discount_percentage' => 'required|numeric',
            'fees.*.discount_type_id' => [
                'required',
                'integer',
                Rule::exists('discount_types', 'id')->whereNull('deleted_at')
            ],
        ];
    }
}
