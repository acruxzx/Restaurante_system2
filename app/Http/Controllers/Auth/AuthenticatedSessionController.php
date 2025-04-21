<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
    
        $user = Auth::user();
    
        if ($user->id_rol == 1) {
            return redirect()->route('turno.seleccionar');
        } elseif ($user->id_rol == 2) {
            return redirect()->route('turno.seleccionar');
        }elseif($user->id_rol==3){
            return redirect()->route('pedidos.index');
        }elseif($user->id_rol==4){
            return redirect()->route('pedidos.index');
        }
    
        return redirect('/');  // Redirigir a una página predeterminada si el rol no es reconocido
    }
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
