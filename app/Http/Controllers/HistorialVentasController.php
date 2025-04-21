<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use App\Models\NumCaja;
use App\Models\MedioPago;
use App\Models\Caja;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
class HistorialVentasController extends Controller
{
    public function historialVentasPorCaja(Request $request)
    {
        // Obtener parámetros de la solicitud
        $id_caja = $request->input('id_caja');
        $turno = $request->input('turno');
        $fecha_inicio = Carbon::parse($request->input('fecha_inicio', now()->startOfDay()));
        $fecha_fin = Carbon::parse($request->input('fecha_fin', now()->endOfDay()));
    
        // Obtener el turno del usuario desde la sesión
        $turnoSeleccionado = Session::get('turno'); // Turno almacenado en la sesión por el cajero
    
        // Si no hay turno en la sesión, puedes asignar un valor predeterminado o redirigir
        if (!$turnoSeleccionado) {
            return redirect()->route('turno.index')->withErrors(['error' => 'Debe seleccionar un turno.']);
        }
    
        // Consultar las ventas con el estado del pedido "Completado"
        $ventas = Venta::whereBetween('created_at', [$fecha_inicio, $fecha_fin])
            ->whereHas('pedido', function ($query) {
                $query->where('id_estadoPedido', 1); // Solo incluir pedidos con estado "Completado"
            });
    
        // Filtrar por id_caja si se especifica
        if ($id_caja) {
            $ventas->where('id_caja', $id_caja);
        }
    
        // Filtrar por turno según el turno de la sesión
        $ventas->where('turno', $turnoSeleccionado);
        
        // Obtener las ventas agrupadas
        $ventas = $ventas->select(
                'id_caja',
                'turno',
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('SUM(total) as total_turno')
            )
            ->groupBy(DB::raw('DATE(created_at)'), 'id_caja', 'turno')  // Agrupar solo por fecha, id_caja y turno
            ->get();
        
        // Evitar duplicados de ventas por turno en la misma fecha
        $ventas = $ventas->unique(function ($venta) {
            return $venta->id_caja . $venta->turno . $venta->fecha;
        });
    
        // Obtener las cajas y bases iniciales
        $num_cajas = NumCaja::all()->keyBy('id'); // Relación base inicial
    
        // Calcular base inicial y saldo final por turno
        foreach ($ventas as $venta) {
            // Obtener base inicial de acuerdo al turno
            $caja_base = $num_cajas->get($venta->id_caja);
            
            if ($venta->turno == 'dia') {
                // Si el turno es día, usar base_dia
                $venta->base_inicial = $caja_base ? $caja_base->base_dia : 0;
            } elseif ($venta->turno == 'noche') {
                // Si el turno es noche, usar base_noche
                $venta->base_inicial = $caja_base ? $caja_base->base_noche : 0;
            } else {
                $venta->base_inicial = $caja_base ? $caja_base->base_inicial : 0;
            }
            
            // Calcular el saldo final
            $venta->saldo_final = $venta->base_inicial + $venta->total_turno;
        }
    
        // Retornar la vista con las ventas y los datos necesarios
        return view('historial.historial', compact(
            'ventas',
            'id_caja',
            'fecha_inicio',
            'fecha_fin',
            'turno',
            'num_cajas'
        ));
    }
    
    
    
    public function productosDeVenta($id_caja, $turno, $fecha)
    {
        // Buscar las ventas del turno específico
        $ventas = Venta::where('id_caja', $id_caja)
        ->where('turno', $turno)
        ->whereDate('created_at', $fecha)
        ->with(['pedido.productoPedidos.precio.producto']) // Cargar la relación del producto a través de precio
        ->get();
        
        // Crear una colección para almacenar los productos
        $productos = collect();
    
        // Iterar sobre las ventas y extraer los productos
        foreach ($ventas as $venta) {
            foreach ($venta->pedido->productoPedidos as $productoPedido) {
                // Acceder al producto a través de la relación precio -> producto
                $producto = $productoPedido->precio->producto;
                
                // Comprobar que el producto existe antes de procesarlo
                if ($producto) {
                    $producto->cantidad = $productoPedido->cantidad; // Cantidad vendida
                    $producto->subtotal = $productoPedido->precio->precio * $productoPedido->cantidad; // Subtotal calculado
                    $productos->push($producto);
                }
            }
        }
    
        // Retornar la vista con los productos
        return view('historial.productos', compact('productos', 'id_caja', 'turno', 'fecha'));
    }
    public function totales(Request $request)
    {
        $fecha = Carbon::parse($request->input('fecha'));
        $turno = $request->input('turno');
        $id_caja = $request->input('id_caja');
        $cajas = NumCaja::all();
    
        // Obtener totales por medio de pago desde la tabla intermedia
        $totalesPorMedioPago = DB::table('ventas')
            ->join('venta_medio_pago', 'ventas.id', '=', 'venta_medio_pago.venta_id')
            ->join('medio_pago', 'venta_medio_pago.id_medio_pago', '=', 'medio_pago.id')
            ->select('medio_pago.medio_pago', DB::raw('SUM(venta_medio_pago.monto) as total'))
            ->whereDate('ventas.created_at', $fecha)
            ->where('ventas.turno', $turno)
            ->where('ventas.id_caja', $id_caja)
            ->groupBy('medio_pago.medio_pago')
            ->pluck('total', 'medio_pago.medio_pago');
    
        // Obtener ventas del día con sus medios de pago
        $ventas = Venta::whereDate('created_at', $fecha)
            ->where('turno', $turno)
            ->where('id_caja', $id_caja)
            ->with(['ventaMedioPago.medioPago']) // Cargar relación con medios usados
            ->get();
    
        return view('historial.totales', compact(
            'totalesPorMedioPago',
            'fecha',
            'turno',
            'id_caja',
            'cajas',
            'ventas'
        ));
    }
    

    public function detalleVenta($fecha, $turno, $id_caja)
    {
        // Buscar las ventas combinadas según filtros
        $ventas = Venta::whereDate('created_at', $fecha)
            ->where('turno', $turno)
            ->where('id_caja', $id_caja)
            ->with('ventaMedioPago.medioPago')
            ->get();
    
        $detalles = collect();
    
        foreach ($ventas as $venta) {
            if ($venta->ventaMedioPago->count() > 1) {
                foreach ($venta->ventaMedioPago as $detalle) {
                    $detalles->push([
                        'medio_pago' => $detalle->medioPago->medio_pago,
                        'monto' => $detalle->monto
                    ]);
                }
            }
        }
    
        return view('historial.detalles_combinados', compact('detalles'));
    }
    

    
}    