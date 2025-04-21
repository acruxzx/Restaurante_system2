<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TurnoController extends Controller
{

      // Mostrar el formulario de selección de turno
      public function index()
      {
          return view('turno.seleccionar-turno'); // Vista del formulario
      }
  
      // Guardar el turno seleccionado en la sesión
      public function guardarTurno(Request $request)
      {
          // Validar el turno seleccionado
          $request->validate([
              'turno' => 'required|in:dia,noche'
          ]);
  
          // Guardar el turno en la sesión
          Session::put('turno', $request->input('turno'));
  
          // Redirigir al índice de pedidos
          return redirect()->route('pedidos.index')->with('success', 'Turno seleccionado correctamente.');
      }
      
}
