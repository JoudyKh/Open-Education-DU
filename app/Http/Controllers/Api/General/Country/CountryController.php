<?php

namespace App\Http\Controllers\Api\General\Country;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Services\General\Country\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(protected CountryService $countryService)
    {}
     /**
     * @OA\Get(
     *     path="/countries",
     *     tags={"App" , "App - Country"},
     *     summary="get all countries",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CountryResource")
     *     )
     * )
     * @OA\Get(
     *     path="/admin/countries",
     *     tags={"Admin" , "Admin - Country"},
     *     summary="get all countries",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CountryResource")
     *     )
     * )
     */
    public function index()
    {
        try {
            return success($this->countryService->index());
        }  catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
