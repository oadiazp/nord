<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ValidateToken
{
    public function handle(Request $request, Closure $next)
    {
        $expectedToken = getenv('AUTH_TOKEN');
        $token = $request->header('token');

        if ($token === 'false') {
            $token = false;
        }

        if ($token != $expectedToken) {
            return new Response(null, 403);
        }

        return $next($request);
    }
}
