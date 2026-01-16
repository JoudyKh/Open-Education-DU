<?php

namespace App\Http\Controllers\Api\App\Auth;

use App\Http\Requests\Api\App\Auth\LoginRequest;
use App\Http\Requests\Api\App\Auth\ResetPasswordRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\App\Auth\AuthService;
use App\Http\Requests\Api\App\Auth\SignUpRequest;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="app/register",
     *      tags={"App", "App - Auth"},
     *      summary="register a new user",
     *      description="register a new user with the provided information",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/SignUpRequest") ,
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="student registration successfully"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *          )
     *      ),
     * )
     */
    public function register(SignUpRequest $request)
    {
        try {
            return success($this->authService->register($request), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return error($e->getMessage(), null, $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/login",
     *      tags={"App", "App - Auth"},
     *     summary="Login existing user",
     *     description="Login using either national_id and password (for Syrian users) or passport_number and password (for non-Syrian users). The default password is the same as the national_id or passport_number value.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"password"},
     *                 @OA\Property(
     *                     property="national_id",
     *                     type="string",
     *                     example="8674"
     *                 ),
     *                 @OA\Property(
     *                     property="passport_number",
     *                     type="string",
     *                     example="64343"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="password"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Login successful"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             )
     *         )
     *     )
     * )
     */

    public function login(LoginRequest $request)
    {
        try {
            return $this->authService->login($request);
        } catch (\Exception $e) {
            return error($e->getMessage(), null, $e->getCode());
        }
    }
    /**
     * @OA\Post(
     *     path="/reset-password",
     *     operationId="reset-password",
     *     summary="Reset password",
     *    tags={"App", "App - Auth"},
     *    security={{ "bearerAuth": {}, "Accept": "json/application" }},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Reset password",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="password", type="string", example="12345678"),
     *                 @OA\Property(property="password_confirmation", type="string", example="12345678"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successfully Changed password",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid"),
     *             @OA\Property(property="errors", type="object", example={"password": {"The password field is required."}})
     *         )
     *     )
     * )
     */

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            return success($this->authService->resetPassword($request));
        } catch (\Exception $e) {
            return error($e->getMessage(), null, $e->getCode());
        }
    }
}
