<?php

namespace App\Http\Requests;

use App\Models\Info;
use App\Rules\OneOrNone;
use Illuminate\Validation\Rule;
use App\Constants\InfoValidationRules;
use Illuminate\Foundation\Http\FormRequest;


/**  
 * @OA\Schema(  
 *     schema="UpdateInfoRequest",  
 *     type="object",  
 *     title="Program About Request",  
 *     description="Request body for updating program about information",  
 *     @OA\Property(  
 *         property="program-about_program_ar",  
 *         type="string",  
 *         description="Program about information in Arabic",  
 *         nullable=true  
 *     ),  
 *     @OA\Property(  
 *         property="program-about_program_en",  
 *         type="string",  
 *         description="Program about information in English",  
 *         nullable=true  
 *     )  
 * )  
 */ 
class UpdateInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request-
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request-
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'program-about_program_ar' => ['string'],
            'program-about_program_en' => ['string']
        ];
    }
}
