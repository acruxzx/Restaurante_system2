<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los filtros de mes y año desde el formulario
        $mes = $request->input('mes');
        $anio = $request->input('anio');
    
        // Consulta base para las ventas, excluyendo las canceladas
        $query = DB::table('ventas')
            ->join('pedidos', 'ventas.id_pedido', '=', 'pedidos.id') // Relación entre ventas y pedidos
            ->join('estado_pedidos', 'pedidos.id_estadoPedido', '=', 'estado_pedidos.id') // Relación entre pedidos y estadoPedido
            ->select(
                DB::raw('MONTH(ventas.created_at) as mes'),
                DB::raw('SUM(ventas.total) as total_ventas')
            )
            ->where('estado_pedidos.estado', '<>', 'cancelado') // Excluir pedidos con estado "cancelado"
            ->where(function ($query) use ($mes, $anio) {
                if ($mes) {
                    $query->whereMonth('ventas.created_at', $mes);
                }
                if ($anio) {
                    $query->whereYear('ventas.created_at', $anio);
                }
            })
            ->groupBy('mes')
            ->orderBy('mes', 'asc');
    
        // Ejecutar la consulta y transformar los resultados en un arreglo
        $ventasPorMes = $query->pluck('total_ventas', 'mes')->toArray();
    
        // Identificar el mes con mayores ventas
        $mesMaxVentas = empty($ventasPorMes) ? null : array_keys($ventasPorMes, max($ventasPorMes))[0];
    
        return view('dashboard', compact('ventasPorMes', 'mesMaxVentas', 'mes', 'anio'));
    }
    
    
}
