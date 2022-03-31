<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class apigate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        if (!$request->hasHeader('x-api-key')) {
            abort(
                response()
                ->json([
                    'code' => 401,
                    'message' => 'Missing API Key'
                ], 401)
            );
        }

        if ($request->header('x-api-key') !== env('API_KEY')) {
            abort(
                response()
                ->json([
                    'code' => 401,
                    'message' => 'Wrong API key'
                ], 401)
            );
        }

        return $next($request);
    }
}
