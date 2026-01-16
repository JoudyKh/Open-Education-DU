<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** 
 * @OA\Schema(  
 *     schema="DoctorResource",  
 *     type="object",  
 *     @OA\Property(property="academic_rank", type="string", example="CS101"),  
 *     @OA\Property(property="email", type="string", example="email@eamil.com"),  
 *     @OA\Property(property="phone", type="string", example="645634"),  
 *     @OA\Property(property="fax", type="string", example="ghdgdgrd"),  
 *     @OA\Property(property="mobile", type="string", example="85423545"),  
 * )  
 */
class DoctorResource extends JsonResource
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
            'academic_rank' => $this->academic_rank,
            'email' => $this->email,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'mobile' => $this->mobile,
            'image' => $this->image,
            'infos' => DoctorAcademicInfoResource::collection($this->infos),
            'academic_positions' => DoctorAcademicPositionResource::collection($this->positions),
            'achievements' => DoctorAchievementResource::collection($this->achievements),
        ];
    }
}
