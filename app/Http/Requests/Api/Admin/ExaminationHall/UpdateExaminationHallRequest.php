<?php

namespace App\Http\Requests\Api\Admin\ExaminationHall;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="UpdateExaminationHallRequest",  
 *     type="object",  
 *   @OA\Property(
 *         property="name",
 *         type="string",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="place",
 *         type="string",
 *         description=""
 *     ), 
 *   @OA\Property(
 *         property="default_capacity",
 *         type="integer",
 *         description=""
 *     ),   
 * )  
 */
class UpdateExaminationHallRequest extends FormRequest
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
            'place' => 'nullable|string|max:255',
            'default_capacity' => 'nullable|numeric',
        ];
    }
}
