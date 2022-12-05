<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    private $allowedEmails = [
        "ahmad@gmail.com",
        "12345678"
    ];

    public function handle(Request $request, Closure $next)
    {
        $error = false;
        if (!$request->hasHeader('X-ITE-Token')) {
            $error = true;
        }
        $token = $request->header('X-ITE-Token');
        try {
            $jsonStr = base64_decode($token);
            $jsonPayload = json_decode($jsonStr, true);
            if (!$jsonPayload) {
                $error = true;
            }
            if (!isset($jsonPayload['email'])) {
                $error = true;
            }
            if (!in_array($jsonPayload['email'], $this->allowedEmails)) {
                $error = true;
            }
        } catch (\Exception $exception) {
            $error = true;
        }

        if ($error) {
            return response()->json(['message' => 'Missing token'], 401);
        }
        return $next($request);
    }
}
