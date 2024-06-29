<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserServices
 *
 * @package App\Services
 */
class UserServices
{
    protected UserRepository $user;

    /**
     * __construct
     *
     * @param UserRepository $user
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * login
     *
     * @param array $loginData
     *
     * @return JsonResponse
     */
    public function login(array $loginData): JsonResponse
    {
        try {
            if (Auth::attempt(['email' => $loginData['email'], 'password' => $loginData['password']])) {
                $user = Auth::user();
                $user['token'] = $user->createToken('Private Access Token')->accessToken;

                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => __('messages.login_success'),
                    'data' => $user
                ], 200);
            }

            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => __('messages.login_failed')
            ], 401);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'status' => $ex->getMessage(),
            ], 500);
        }
    }
}
