<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademicInfoResource extends JsonResource
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
            'type' => $this->type,
            'high_school_type' => $this->high_school_type,
            'high_school_certificate_source' => $this->high_school_certificate_source,
            'total_student_score' => $this->total_student_score,
            'total_certificate_score' => $this->total_certificate_score,
            'high_school_year' => $this->high_school_year,
            'differential_rate' => $this->differential_rate,
            'english_language_degree' => $this->english_language_degree,
            'french_language_degree' => $this->french_language_degree,
            'religious_education_degree' => $this->religious_education_degree,
            'high_school_certificate_language' => $this->high_school_certificate_language,
            'high_school_certificate_photo' => $this->high_school_certificate_photo,
            'differential_sum' => $this->differential_sum,
            'institute_name' => $this->institute_name,
            'institute_specialization' => $this->institute_specialization,
            'graduation_rate' => $this->graduation_rate,
            'graduation_year' => $this->graduation_year,
            'institute_certificate_image' => $this->institute_certificate_image,
            'institute_transcript_file' => $this->institute_transcript_file,
            'document_decisive' => $this->document_decisive,
        ];
    }
}
