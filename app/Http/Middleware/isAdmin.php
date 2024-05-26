<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('api')->user()->user_type !== 'admin') {
            return failResponse(403, __('auth.forbidden.admin_only'));
        }
        return $next($request);
    }
}
