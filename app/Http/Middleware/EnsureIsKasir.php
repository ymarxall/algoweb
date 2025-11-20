<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsKasir
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isKasir()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized. Kasir access required.'], 403);
            }
            return redirect('/login')->with('error', 'Anda harus login sebagai kasir terlebih dahulu.');
        }

        return $next($request);
    }
}
