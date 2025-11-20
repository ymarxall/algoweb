<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureSessionActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan cart session always exists
        if (Session::get('cart') === null) {
            Session::put('cart', []);
        }

        // Pastikan table_id exists (redirect ke meja 1 jika tidak)
        if ($request->is('checkout', 'cart/*') && !Session::has('table_id')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Session expired. Silakan reload halaman.',
                    'redirect' => '/meja/1'
                ], 419);
            }
            return redirect()->route('customer.menu', ['no' => 1]);
        }

        return $next($request);
    }
}
