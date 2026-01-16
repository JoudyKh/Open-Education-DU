<?php

namespace App\Http\Controllers\Api\Admin\Log;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogResource;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
 * @OA\Get(
 *     path="/admin/logs",
 *     tags={"Admin", "Admin - Log"},
 *     summary="Get all logs",
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *     )
 * )
 */
    public function index()
    {
        return success(LogResource::collection(Log::with('user')->orderByDesc('created_at')->paginate(config('app.pagination_limit'))));
    }
}
