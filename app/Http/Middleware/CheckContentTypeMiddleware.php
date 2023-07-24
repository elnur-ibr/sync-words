<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckContentTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Forcing to accept application/json
        $request->headers->add(['Accept' => 'application/json']);

        if ($request->header('Content-Type') !== 'application/json') {
            abort(400, 'Content type should be application/json');
        }

        return $next($request);
    }
}
