<?php

namespace App\Http\Controllers\Api\General\Nationality;

use App\Http\Controllers\Controller;
use App\Models\Nationality;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/nationalities",
     *     tags={"App" , "App - Nationality"},
     *     summary="get all nationalities",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     )
     * )
     * @OA\Get(
     *     path="/admin/nationalities",
     *     tags={"Admin" , "Admin - Nationality"},
     *     summary="get all nationalities",
     *      security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     )
     * )
     */
    public function index()
    {
        return success(Nationality::get());
    }
}
