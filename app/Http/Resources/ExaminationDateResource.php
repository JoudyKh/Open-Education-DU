<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**  
 * @OA\Schema(  
 *     schema="ExaminationDateResource",  
 *     type="object",  
 *   @OA\Property(
 *         property="start_time",
 *         type="string",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="end_time",
 *         type="integer",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="semester_id",
 *         type="integer",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="curriculum_id",
 *         type="integer",
 *         description=""
 *     ),   
 *   @OA\Property(
 *         property="date",
 *         type="integer",
 *         description=""
 *     ),   
 * )  
 */
class ExaminationDateResource extends JsonResource
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
