<?php

namespace App\Http\Requests\Api\Admin\UniversityServicesFee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**  
 * @OA\Schema(  
 *     schema="UpdateUniversityServicesFeeRequest",  
 *     type="object",  
 *   @OA\Property(
 *         property="name",
 *         type="string",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="fee",
 *         type="double",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="discount_percentage",
 *         type="double",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="discount_type_id",
 *         type="double",
 *         description="discount type ids"
 *     ),   
 * )  
 */
class UpdateUniversityServicesFeeRequest extends FormRequest
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
            'fee' => 'nullable|numeric',
            'discount_percentage' => 'nullable|numeric',
            'discount_type_id' => [
                'nullable',
                'integer',
                Rule::exists('discount_types', 'id')->whereNull('deleted_at')
            ],
        ];
    }
}
