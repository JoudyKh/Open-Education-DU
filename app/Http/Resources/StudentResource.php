<?php

namespace App\Http\Resources;

use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="StudentResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="first_name_ar", type="string", example="أحمد"),
 *     @OA\Property(property="first_name_en", type="string", example="Ahmad"),
 *     @OA\Property(property="last_name_ar", type="string", example="الزهيري"),
 *     @OA\Property(property="last_name_en", type="string", example="Al-Zuhairi"),
 *     @OA\Property(property="father_name_ar", type="string", example="محمد"),
 *     @OA\Property(property="father_name_en", type="string", example="Mohammed"),
 *     @OA\Property(property="mother_name_ar", type="string", example="فاطمة"),
 *     @OA\Property(property="mother_name_en", type="string", example="Fatima"),
 *     @OA\Property(property="birth_place_ar", type="string", example="دمشق"),
 *     @OA\Property(property="birth_place_en", type="string", example="Damascus"),
 *     @OA\Property(property="first_name", type="string", example="Ahmad"),
 *     @OA\Property(property="last_name", type="string", example="Al-Zuhairi"),
 *     @OA\Property(property="father_name", type="string", example="Mohammed"),
 *     @OA\Property(property="mother_name", type="string", example="Fatima"),
 *     @OA\Property(property="birth_place", type="string", example="Damascus"),
 *     @OA\Property(property="national_id", type="string", maxLength=255, nullable=true, example="1234567890"),
 *     @OA\Property(property="birth_date", type="string", format="date-time", example="1995-05-15T00:00:00Z"),
 *     @OA\Property(property="nationality_id", type="integer", example=1),
 *     @OA\Property(property="id_number", type="integer", example=987654321),
 *     @OA\Property(property="gender", type="string", enum={"male", "female"}, example="male"),
 *     @OA\Property(property="place_of_registration", type="string", maxLength=255, example="Registration Place"),
 *     @OA\Property(property="number_registration", type="string", maxLength=255, example="123456"),
 *     @OA\Property(property="number_passport", type="string", maxLength=255, nullable=true, example="A12345678"),
 *     @OA\Property(property="division_recruitment", type="string", maxLength=255, nullable=true, example="Division X"),
 *     @OA\Property(property="province_id", type="integer", example=1),
 *     @OA\Property(property="university_id", type="integer", example=123456),
 *     @OA\Property(property="personal_picture", type="string", format="binary", example="file.jpg"),
 *     @OA\Property(property="id_front_side_image", type="string", format="binary", example="file.jpg"),
 *     @OA\Property(property="id_back_side_image", type="string", format="binary", example="file.jpg"),
 * )
 */
class StudentResource extends JsonResource
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
            'national_id' => $this->national_id,
            'birth_date' => $this->birth_date,
            'id_number' => $this->id_number,
            'gender' => $this->gender,
            'place_of_registration' => $this->place_of_registration,
            'registration_number' => $this->registration_number,
            'passport_number' => $this->passport_number,
            'recruitment_division' => $this->recruitment_division,
            'province_id' => $this->province_id,
            'university_id' => $this->university_id,
            'personal_picture' => $this->personal_picture,
            'id_front_side_image' => $this->id_front_side_image,
            'id_back_side_image' => $this->id_back_side_image,
            'nationality_id' => $this->nationality_id,
            'is_active' => $this->is_active,
            'student_type' => $this->student_type,
            'contact_info' => ContactInfoResource::make($this?->contactInfo),
            'academic_info' => AcademicInfoResource::make($this?->academicInfo),
        ];

        // if (Auth::user() && Auth::user()->hasRole(Constants::SUPER_ADMIN_ROLE)) {
            $array['first_name_ar'] = $this->first_name_ar;
            $array['first_name_en'] = $this->first_name_en;
            $array['last_name_ar'] = $this->last_name_ar;
            $array['last_name_en'] = $this->last_name_en;
            $array['father_name_ar'] = $this->father_name_ar;
            $array['father_name_en'] = $this->father_name_en;
            $array['mother_name_ar'] = $this->mother_name_ar;
            $array['mother_name_en'] = $this->mother_name_en;
            $array['birth_place_ar'] = $this->birth_place_ar;
            $array['birth_place_en'] = $this->birth_place_en;
            $array['nationality_ar'] = $this->nationality->ar_name;
            $array['nationality_en'] = $this->nationality->en_name;
            $array['province_ar'] = $this->province?->ar_name;
            $array['province_en'] = $this->province?->en_name;
        // } else {
        //     $locale = app()->getLocale();
        //     $array['first_name'] = $this->{'first_name_'. $locale};
        //     $array['last_name'] = $this->{'last_name_' . $locale};
        //     $array['father_name'] = $this->{'father_name_' . $locale};
        //     $array['mother_name'] = $this->{'mother_name_' . $locale};
        //     $array['birth_place'] = $this?->{'birth_place_' . $locale};
        //     $array['nationality'] = $this->nationality->{'name_' . $locale};
        //     $array['province'] = $this->province?->{'name_' . $locale};
        // }

        return $array;
    }
}
