<?php

namespace App\Http\Controllers\Api\General\City;

use App\Http\Controllers\Controller;
use App\Services\General\City\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(protected CityService $cityService)
    {}
     /**
     * @OA\Get(
     *     path="/cities",
     *     tags={"App" , "App - City"},
     *     summary="get all cities",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CityResource")
     *     )
     * )
     * @OA\Get(
     *     path="/admin/cities",
     *     tags={"Admin" , "Admin - City"},
     *     summary="get all cities",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CityResource")
     *     )
     * )
     */
    public function index()
    {
        try {
            return success($this->cityService->index());
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
