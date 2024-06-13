<?php

namespace App\Http\Middleware;

use App\Http\Requests\OrderCreateRequest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderValidateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $customRequest = new OrderCreateRequest();
        $reflection = new \ReflectionClass($customRequest);
        $rules = $reflection->getMethod('rules')->invoke($customRequest);

        $request->validate($rules);

        return $next($request);
    }
}
