<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**  
 * @OA\Schema(  
 *     schema="UniversityServicesFeeResource",  
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
class UniversityServicesFeeResource extends JsonResource
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
