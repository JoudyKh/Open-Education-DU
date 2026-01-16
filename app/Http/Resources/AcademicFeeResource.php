<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**  
 * @OA\Schema(  
 *     schema="AcademicFeeResource",  
 *     type="object",  
 *     @OA\Property(property="curriculums", type="string", example="1", description="you can add many array items"),
 *     @OA\Property(property="student_year", type="string", format="date", example="2023-09-01"),  
 *     @OA\Property(property="fee", type="number", format="double", example=50), 
 *     @OA\Property(property="student_registrations_count", type="integer", example="1"), 
 * )  
 */ 
class AcademicFeeResource extends JsonResource
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
        // $array = [

        // ];
        // return $array;
    }
}
