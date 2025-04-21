<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarCajaAbierta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Verificar si hay una caja abierta
         $cajaAbierta = Caja::where('estado', 'abierto')->first();

         if (!$cajaAbierta) {
             // Si no hay caja abierta, redirigir al formulario de apertura
             return redirect()->route('caja.abrir')->with('error', 'Debes abrir una caja primero.');
         }
 
         // Si hay caja abierta, continuar con la solicitud
         return $next($request);
    }
}
