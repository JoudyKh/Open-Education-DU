<?php

namespace App\Http\Requests\Api\Admin\News;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CreateNewsRequest",
 *     type="object",
 *     required={"ar_title", "en_title", "ar_description", "en_description", "images[]"},
 *     @OA\Property(property="ar_title", type="string", maxLength=255, example="exampleValueAR"),
 *     @OA\Property(property="en_title", type="string", maxLength=255, example="exampleValueEN"),
 *     @OA\Property(property="ar_description", type="string",maxLength=255, example="exampleValueAR"),
 *     @OA\Property(property="en_description", type="string", maxLength=255, example="exampleValueEN"),
 *    @OA\Property(
 *         property="images[]",
 *         type="array",
 *         @OA\Items(type="string", format="binary")
 *     ),  
 * )
 */
class CreateNewsRequest extends FormRequest
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
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ar_description' => 'required',
            'en_description' => 'required',
            'images' => 'required|array',
        ];
    }
}
