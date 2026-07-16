<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PrakerinMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isPrakerin()) {
            return $next($request);
        }

        return redirect()->route('dashboard')->withErrors(['error' => 'Akses ditolak. Halaman ini hanya untuk Prakerin.']);
    }
}
