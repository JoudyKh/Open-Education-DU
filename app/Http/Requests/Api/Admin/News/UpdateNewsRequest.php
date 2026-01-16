<?php

namespace App\Http\Requests\Api\Admin\News;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateNewsRequest",
 *     type="object",
 *     @OA\Property(property="ar_title", type="string", maxLength=255, example="exampleValueAR"),
 *     @OA\Property(property="en_title", type="string", maxLength=255, example="exampleValueEN"),
 *     @OA\Property(property="ar_description", type="string",maxLength=255, example="exampleValueAR"),
 *     @OA\Property(property="en_description", type="string", maxLength=255, example="exampleValueEN"),
 *    @OA\Property(
 *         property="images[]",
 *         type="array",
 *         @OA\Items(type="string", format="binary")
 *     ),  
 *     @OA\Property(property="delete_images[0]", type="string", example="1", description="image ids want to delete, you can add many array items"),
 * )
 */
class UpdateNewsRequest extends FormRequest
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
            'ar_title' => 'string|max:255',
            'en_title' => 'string|max:255',
            'ar_description' => '',
            'en_description' => '',
            'images' => 'array',
            'delete_images' => 'array',
            'delete_images.*' => 'exists:news_images,id,news_id,' . $this->route('news')->id,
        ];
    }
}
