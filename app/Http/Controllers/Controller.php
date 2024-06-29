<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * @package App\Http\Controllers
 *
 * @OA\Info(
 *    title="Documentation: User To Do",
 *    version="1.0.0",
 * ),
 *
 * @OA\SecurityScheme(
 *      securityScheme="x_api_key",
 *      type="apiKey",
 *      in="header",
 *      name="X-API-KEY"
 * )
 * @OA\SecurityScheme(
 *      securityScheme="app_lang",
 *      type="apiKey",
 *      in="header",
 *      name="app-language"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="passport",
 *     type="http",
 *     in="header",
 *     name="bearer",
 *     bearerFormat="JWT"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
