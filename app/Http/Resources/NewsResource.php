<?php

namespace App\Http\Resources;

use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="NewsResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(
 *         property="images[]",
 *         type="array",
 *         @OA\Items(type="string", example="image_url")
 *     ),
 *     @OA\Property(property="en_title", type="string", example="exampleValueEN"),
 *     @OA\Property(property="ar_title", type="string", example="exampleValueAR"),
 *     @OA\Property(property="en_description", type="string", example="exampleValueEN"),
 *     @OA\Property(property="ar_description", type="string", example="exampleValueAR"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 * )
 */
class NewsResource extends JsonResource
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
        $array =  [
            'id' => $this->id,
            'images' => $this->images,
        ];
        if(Auth::user() &&  Auth::user()->hasRole(Constants::SUPER_ADMIN_ROLE)){
            $array['ar_title'] = $this->getTranslation('title', 'ar');
            $array['en_title'] = $this->getTranslation('title', 'en');
            $array['ar_description'] = $this->getTranslation('description', 'ar');
            $array['en_description'] = $this->getTranslation('description', 'en');
        }else{
            $array['title'] = $this->title;
            $array['description'] = $this->description;
        }
        if($this->deleted_at)
            $array['deleted_at'] = $this->deleted_at;
        return $array;
    
    }
}
