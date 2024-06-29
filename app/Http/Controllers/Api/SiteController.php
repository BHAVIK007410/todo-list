<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Services\UserServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class SiteController
 *
 * @package App\Http\Controllers\Api
 */
class SiteController extends Controller
{
    protected UserServices $user;

    /**
     * __construct
     *
     * @param UserServices $user
     *
     * @return void
     */
    public function __construct(UserServices $user)
    {
        $this->user = $user;
    }

    /**
     * @OA\Post(
     *     path="/api/user/login",
     *     summary="User login",
     *     description="Logs in a user and returns user data with a token",
     *     operationId="loginUser",
     *     tags={"Login"},
     *     security={{"x_api_key":{}, "app_lang":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="bhavik.test@yopmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="User12345")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User logged in successfully."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=930952413),
     *                 @OA\Property(property="first_name", type="string", example="Bhavik"),
     *                 @OA\Property(property="last_name", type="string", example="Bhatiya"),
     *                 @OA\Property(property="email", type="string", format="email", example="bhavik.test@yopmail.com"),
     *                 @OA\Property(property="email_verified_at", type="string", format="datetime", nullable=true, example=null),
     *                 @OA\Property(property="created_at", type="string", format="datetime", example="2024-06-29T04:48:31.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime", example="2024-06-29T04:48:31.000000Z"),
     *                 @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true, example=null),
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGci.....")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=401),
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Email or password wrong.")
     *         )
     *     )
     * )
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     *
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $loginData = $request->validated();
            return $this->user->login($loginData);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     * logout
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->token()->revoke();
            return response()->json(
                [
                    'status' => 200,
                    'success' => true,
                    'message' => __('messages.logout_success'),
                ],
                500
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 500,
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500
            );
        }
    }
}
