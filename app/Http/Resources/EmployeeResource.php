<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="EmployeeResource",
 *     type="object",
 *     @OA\Property(property="first_name", type="string", maxLength=255, example="John"),  
 *     @OA\Property(property="last_name", type="string", maxLength=255, example="Doe"),  
 *     @OA\Property(property="father_name", type="string", maxLength=255, example="Richard"),  
 *     @OA\Property(property="mother_name", type="string", maxLength=255, example="Jane"),  
 *     @OA\Property(property="birth_place", type="string", maxLength=255, example="New York"),  
 *     @OA\Property(property="birth_date", type="string", format="date", example="1990-01-01"),  
 *     @OA\Property(property="national_id", type="string", maxLength=255, example="123456789"),  
 *     @OA\Property(property="place_of_registration", type="string", maxLength=255, example="New York"),  
 *     @OA\Property(property="id_front_side_image", type="string", format="binary"),  
 *     @OA\Property(property="id_back_side_image", type="string", format="binary"),  
 *     @OA\Property(property="admin_decision_date", type="string", format="date", example="2024-01-01"),  
 *     @OA\Property(property="admin_decision_number", type="string", maxLength=255, example="m213") 
 * )
 */
class EmployeeResource extends JsonResource
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
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date,
            'national_id' => $this->national_id,
            'place_of_registration' => $this->place_of_registration,
            'id_front_side_image' => $this->id_front_side_image,
            'id_back_side_image' => $this->id_back_side_image,
            'admin_decision_date' => $this->admin_decision_date,
            'admin_decision_number' => $this->admin_decision_number,
        ];
    }
}
