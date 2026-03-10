<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VinyleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder aux vinyles.');
        }

        if (!auth()->user()->isVinyleUser()) {
            abort(403, 'Accès refusé. Vous n\'avez pas l\'autorisation d\'accéder aux vinyles.');
        }

        return $next($request);
    }
}
