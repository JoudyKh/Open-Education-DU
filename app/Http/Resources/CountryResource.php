<?php

namespace App\Http\Resources;

use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="CountryResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name_ar", type="string", example="exampleValueEN"),
 *     @OA\Property(property="name_en", type="string", example="exampleValueAR"),
 *     @OA\Property(property="code", type="string", example="exampleValueEN"),
 * )
 */
class CountryResource extends JsonResource
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
        ];
        if (Auth::user() && Auth::user()->hasRole(Constants::SUPER_ADMIN_ROLE)) {
            $array['name_ar'] = $this->name_ar;
            $array['name_en'] = $this->name_en;
        }else{
            $locale = app()->getLocale();
            $array['name'] = $this->{'name_' . $locale};
        }
        return $array;
    }
}
