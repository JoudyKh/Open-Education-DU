<?php

namespace App\Http\Requests\Api\Admin\Doctor\Achievement;

use App\Constants\Constants;
use Illuminate\Foundation\Http\FormRequest;

/**  
 * @OA\Schema(  
 *     schema="CreateDoctorAchievementRequest",  
 *     type="object",  
 *     required={  
 *         "title", "text", "type",   
 *     },  
 *     @OA\Property(property="title", type="string", example="CS101"),  
 *     @OA\Property(property="text"),
 *     @OA\Property(property="type", enum={"books_and_scientific_publications", "scientific_research", "conferences", "teaching_experience"}),  
 * )  
 */ 
class CreateDoctorAchievementRequest extends FormRequest
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
            'title' => 'required',
            'text' => 'required',
            'type' => 'required|in:' . implode(',', Constants::DOCTOR_ACHIEVEMENTS_TYPE),
        ];
    }
}
