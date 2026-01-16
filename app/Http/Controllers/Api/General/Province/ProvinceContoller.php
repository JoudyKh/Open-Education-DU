<?php

namespace App\Http\Controllers\Api\General\Province;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProvinceResource;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceContoller extends Controller
{
     /**
     * @OA\Get(
     *     path="/provinces",
     *     tags={"App" , "App - Provices"},
     *     summary="get all provinces",
     *    @OA\Parameter(
     *         name="locale",
     *         in="header",
     *         description="Locale of the branch data (optional)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"ar", "en"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ProvinceResource")
     *     )
     * )
     * @OA\Get(
     *     path="/admin/provinces",
     *     tags={"Admin" , "Admin - Province"},
     *     summary="get all provinces",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ProvinceResource")
     *     )
     * )
     */
    public function index()
    {
        return success(ProvinceResource::collection(Province::get()));
    }
}
