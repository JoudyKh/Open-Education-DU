<?php

namespace App\Http\Resources;

use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CurriculumWithSemesterResource extends JsonResource
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
        $array = [
            'id' => $this->id,
            'code' => $this->code,
            'min_pass_mark' => $this->min_pass_mark,
            'theoretical_mark' => $this->theoretical_mark,
            'practical_mark' => $this->practical_mark,
            'assistances_marks' => $this->assistances_marks,
            'type' => $this->type,
            'is_optional' => $this->is_optional,
            'description_file' => $this->description_file,
            'in_program' => $this->in_program,
            'year' => $this->year,
            'original_semester' => SingleSemesterResource::make($this->semester),
        ];
        if (Auth::user() && Auth::user()->hasRole(Constants::SUPER_ADMIN_ROLE)) {
            $array['name_ar'] = $this->name_ar;
            $array['name_en'] = $this->name_en;
        } else {
            $locale = app()->getLocale();
            $array['name'] = $this->{'name_' . $locale};
        }
        return $array;
    }
}
