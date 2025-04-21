<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verificar si el usuario está autenticado y si su rol coincide con el requerido
        if (!Auth::check() || Auth::user()->id_rol != $role) {
            // Si no tiene el rol adecuado, redirigir a otra página (ejemplo: dashboard)
            return redirect('/')->with('error', 'No tienes acceso a esta página.');
        }

        // Si tiene el rol adecuado, continuar con la solicitud
        return $next($request);
    }
}
