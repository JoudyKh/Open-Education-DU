<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**  
 * @OA\Schema(  
 *     schema="StudentMarkResource",  
 *     type="object",  
 *     required={  
 *         "semester_id", "curriculum_id", "mark", "written_mark"  
 *     },  
 *     @OA\Property(property="semester_id", type="integer", example=1, description="The ID of the semester"),  
 *     @OA\Property(property="curriculum_id", type="integer", example=1, description="The ID of the curriculum associated with the semester"),  
 *     @OA\Property(property="mark", type="number", format="double", example=85, description="The mark obtained by the student"),  
 *     @OA\Property(property="written_mark", type="string", example="A", description="The written mark representation"),  
 * )  
 */  
class StudentMarkResource extends JsonResource
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
