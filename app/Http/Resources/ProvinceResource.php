<?php

namespace App\Http\Resources;

use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="ProvinceResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="key", type="string", example="key"),
 *     @OA\Property(property="en_name", type="string", example="exampleValueEN"),
 *     @OA\Property(property="ar_name", type="string", example="exampleValueAR"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 * )
 */
class ProvinceResource extends JsonResource
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
            'key' => $this->key,
        ];
        if(Auth::user() &&  Auth::user()->hasRole(Constants::SUPER_ADMIN_ROLE)){
            $array['ar_name'] = $this->ar_name;
            $array['en_name'] = $this->en_name;
        }else{
            $locale = app()->getLocale();
            $array['name'] = $this->{$locale . '_name'};
        }
        return $array;
    }
}
