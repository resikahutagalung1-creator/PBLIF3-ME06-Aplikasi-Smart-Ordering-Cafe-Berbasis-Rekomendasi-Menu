<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KasirMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            !session('kasir_login') ||
            session('kasir_role') !== 'kasir'
        ) {
            return redirect('/kasir/login')
                ->with('error', 'Silakan login sebagai kasir terlebih dahulu.');
        }

        return $next($request);
    }
}