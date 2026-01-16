<?php

namespace App\Http\Requests\Api\Admin\ExaminationHall;

use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="CreateExaminationHallRequest",  
 *     type="object",  
 *   @OA\Property(
 *         property="halls[0][name]",
 *         type="string",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="halls[0][place]",
 *         type="string",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="halls[0][default_capacity]",
 *         type="integer",
 *         description=""
 *     ),   
 * )  
 */
class CreateExaminationHallRequest extends FormRequest
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
            'halls' => 'required|array',
            'halls.*.name' => 'required|string|max:255',
            'halls.*.place' => 'required|string|max:255',
            'halls.*.default_capacity' => 'required|numeric',
        ];
    }
}
