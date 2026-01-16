<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**  
 * @OA\Schema(  
 *     schema="SemesterResource",  
 *     type="object",  
 *     @OA\Property(property="name", type="string", maxLength=255, example="Advanced Mathematics"),  
 *     @OA\Property(property="year", type="string", format="date", example="2023-09-01"),  
 *     @OA\Property(property="start_date", type="string", format="date", example="2023-09-01"),  
 *     @OA\Property(property="end_date", type="string", format="date", example="2024-06-01"),  
 *     @OA\Property(property="registration_start_date", type="string", format="date", example="2023-07-01"),  
 *     @OA\Property(property="registration_end_date", type="string", format="date", example="2023-08-30"),  
 *     @OA\Property(property="has_exception", enum={"0", "1"}),  
 *     @OA\Property(property="max_fail_regular", type="number", format="double", example=2),  
 *     @OA\Property(property="max_fail_dropout", type="number", format="double", example=3),  
 *     @OA\Property(property="count_curriculums_optional", type="number", format="double", example=5),  
 *     @OA\Property(property="count_curriculums_mandatory", type="number", format="double", example=8)  
 * )  
 */ 
class SemesterResource extends JsonResource
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
            'name' => $this->name,
            'year' => $this->year,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'registration_start_date' => $this->registration_start_date,
            'registration_end_date' => $this->registration_end_date,
            'has_exception' => $this->has_exception,
            'max_fail_regular' => $this->max_fail_regular,
            'max_fail_dropout' => $this->max_fail_dropout,
            'count_curriculums_optional' => $this->count_curriculums_optional,
            'count_curriculums_mandatory' => $this->count_curriculums_mandatory,
            'is_available' => $this->is_available,
            'curriculums' => CurriculumResource::collection($this->curriculums),
            'discounts' => DiscountResource::collection($this->discounts),
            'academic_fees' => AcademicFeeResource::collection($this->academicFees),
            'university_services_fees' => UniversityServicesFeeResource::collection($this->universityServicesFees),
            'examination_halls' => ExaminationHallResource::collection($this->examinationHalls),
            'examination_dates' => ExaminationDateResource::collection($this->examinationDates),
        ];
    }
}
