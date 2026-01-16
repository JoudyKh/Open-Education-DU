<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**  
 * @OA\Schema(  
 *     schema="DoctorAcademicPositionResource",  
 *     type="object",   
 *     @OA\Property(property="name", type="string", example="CS101"),  
 *     @OA\Property(property="start_year", type="string", format="date", example="2023-05-15"),
 *     @OA\Property(property="end_year", type="string", format="date", example="2023-05-15"),
 * )  
 */  
class DoctorAcademicPositionResource extends JsonResource
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
