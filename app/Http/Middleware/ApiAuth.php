<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiAuth
 *
 * @package App\Http\Middleware
 */
class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $request->headers->set('Content-Type', 'application/json');
        if (!$request->header('app-language')) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __("messages.missing_lang_auth")
                ],
                400
            );
        }

        $env = App::environment();
        App::setLocale($request->header('app-language'));

        if ($request->header('X-API-Key') != config("services.auth.key.{$env}")) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __("messages.headerauth")
                ],
                400
            );
        }

        return $next($request);
    }
}
