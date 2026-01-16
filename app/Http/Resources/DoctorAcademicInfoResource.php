<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**  
 * @OA\Schema(  
 *     schema="DoctorAcademicInfoResource",  
 *     type="object",  
 *     @OA\Property(property="title", type="string", example="CS101"),  
 *     @OA\Property(property="thesis_title", type="string", example="Computer Science 101"),  
 *     @OA\Property(property="university_name", type="string", example="علوم الكمبيوتر 101"),  
 *     @OA\Property(property="collage_name", type="string", example="علوم الكمبيوتر 101"),  
 *     @OA\Property(property="specialization", type="string", example="علوم الكمبيوتر 101"),  
 *     @OA\Property(property="degree", type="string", example="علوم الكمبيوتر 101"),  
 *     @OA\Property(property="rate", type="number", format="double", example=50),  
 *     @OA\Property(property="graduation_year", type="string", format="date", example="2023-05-15"),
 * )  
 */  
class DoctorAcademicInfoResource extends JsonResource
{
       /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed> | \Illuminate\Pagination\AbstractPaginator| \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($data) 
    {
        /*
        This simply checks if the given data is and instance of Laravel's paginator classes
         and if it is,
        it just modifies the underlying collection and returns the same paginator instance
        */
        if (is_a($data, \Illuminate\Pagination\AbstractPaginator::class)) {
            $data->setCollection(
                $data->getCollection()->map(function ($listing) {
                    return new static($listing);
                })
            );
            return $data;
        }

        return parent::collection($data);
    }
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
