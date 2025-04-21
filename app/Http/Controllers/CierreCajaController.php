<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NumCaja;
use App\Models\Venta;
use App\Models\CierreCaja;
use Carbon\Carbon;

class CierreCajaController extends Controller
{
    public function index()
    {
        $cajas = NumCaja::all();
        return view('cierres_cajas.index', compact('cajas'));
    }

    public function calcular(Request $request)
    {
        $request->validate([
            'id_caja' => 'required|exists:num_caja,id',
            'turno' => 'required|in:dia,noche',
            'fecha' => 'required|date',
        ]);

        // Obtener el monto inicial de la caja
        $caja = Caja::find($request->id_caja);
        $montoInicial = $caja->monto_inicial;

        // Obtener ventas del turno seleccionado
        $ventas = Venta::where('id_caja', $request->id_caja)
            ->where('turno', $request->turno)
            ->whereDate('fecha', $request->fecha)
            ->get();

        $totalVentas = $ventas->sum('monto');

        return response()->json([
            'monto_inicial' => $montoInicial,
            'total_ventas' => $totalVentas,
            'monto_final' => $montoInicial + $totalVentas,
        ]);
    }

    public function cerrar(Request $request)
    {
        $request->validate([
            'id_caja' => 'required|exists:num_caja,id',
            'turno' => 'required|in:dia,noche',
            'fecha' => 'required|date',
            'monto_inicial' => 'required|numeric',
            'total_ventas' => 'required|numeric',
            'monto_final' => 'required|numeric',
        ]);

        CierreCaja::create([
            'id_caja' => $request->id_caja,
            'turno' => $request->turno,
            'fecha' => $request->fecha,
            'monto_inicial' => $request->monto_inicial,
            'total_ventas' => $request->total_ventas,
            'monto_final' => $request->monto_final,
        ]);

        return redirect()->route('cierres_caja.index')->with('success', 'Turno cerrado correctamente.');
    }
}
