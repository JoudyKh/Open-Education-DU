<?php

namespace App\Http\Resources;

use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="CityResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name_ar", type="string", example="exampleValueEN"),
 *     @OA\Property(property="name_en", type="string", example="exampleValueAR"),
 *     @OA\Property(property="country_name_ar", type="string", example="exampleValueAR"),
 *     @OA\Property(property="country_name_en", type="string", example="exampleValueAR"),
 *     @OA\Property(property="code", type="string", example="exampleValueEN"),
 *     @OA\Property(property="country_id", type="integer", example="1"),
 * )
 */
class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed> | \Illuminate\Pagination\AbstractPaginator| \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function toArray(Request $request): array
    {
        $array = [
            'id' => $this->id,
            'code' => $this->code,
        ];
        if (Auth::user() && Auth::user()->hasRole(Constants::SUPER_ADMIN_ROLE)) {
            $array['name_ar'] = $this->name_ar;
            $array['name_en'] = $this->name_en;
            $array['country_name_ar'] = $this->country->name_ar;
            $array['country_name_en'] = $this->country->name_en;
        }else{
            $locale = app()->getLocale();
            $array['name'] = $this->{'name_' . $locale};
            $array['country_name'] = $this->country->{'name_' . $locale};
        }
        return $array;
    }
}
