<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaMedioPago;
use Illuminate\Support\Facades\DB;
use App\Models\MedioPago;
use App\Models\NumCaja;
use App\Models\Pedido;
use App\Models\ProductoPedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\VentaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class VentaController extends Controller
{
   


    public function index(Request $request): View
    {
        $ventas = Venta::paginate();

        
        return view('venta.index', compact('ventas'))
            ->with('i', ($request->input('page', 1) - 1) * $ventas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($pedidoId)
    {
        // Obtener el pedido junto con los productos asociados, incluyendo el precio y descuento
        $pedido = Pedido::with('productoPedidos.precio')->findOrFail($pedidoId);
    
        // Calcular el total de la factura considerando el descuento de cada producto
        $totalFactura = $pedido->productoPedidos->sum(function ($productoPedido) {
            $precioUnitario = $productoPedido->precio->precio ?? 0;
            $cantidad = $productoPedido->cantidad;
            $descuento = $productoPedido->descuento ?? 0;  // Asegurarse de que el descuento sea 0 si no existe
    
            // Aplicar el descuento al total del producto
            $precioConDescuento = $precioUnitario * (1 - $descuento / 100);  // Descuento como porcentaje
    
            return $precioConDescuento * $cantidad;
        });
    
        // Redondear el total de la factura a 2 decimales
        $totalFactura = round($totalFactura, 2);
    
        // Obtener los medios de pago y las cajas
        $medioPagos = MedioPago::all();
        $cajas = NumCaja::all();
    
        // Retornar la vista con los datos
        return view('venta.create', compact('medioPagos', 'cajas', 'pedidoId', 'totalFactura'));
    }
    

    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(VentaRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $user = Auth::user();
    
            // Crear la venta
            $venta = new Venta();
            $venta->id_caja = $validated['id_caja'];
            $venta->total = $validated['total'];
            $venta->id_pedido = $validated['id_pedido'];
    
            // Determinar turno según el rol
            if ($user->id_rol == '3') {
                $venta->turno = 'dia';
            } elseif ($user->id_rol == '4') {
                $venta->turno = 'noche';
            } elseif (in_array($user->id_rol, ['1', '2'])) {
                $turnoSeleccionado = Session::get('turno');
                if (!$turnoSeleccionado) {
                    return redirect()->back()->withErrors(['error' => 'Debe seleccionar un turno.']);
                }
                $venta->turno = $turnoSeleccionado;
            } else {
                $venta->turno = 'desconocido';
            }
    
            // Guardar la venta
            $venta->save();
    
           // Registrar los medios de pago
            $medios = $request->input('id_medioPago');
            $montos = $request->input('monto_combinado');

            if (is_array($medios) && is_array($montos)) {
                // Pago combinado
                if (count($medios) !== count($montos)) {
                    return redirect()->back()->withErrors(['error' => 'Debe seleccionar los medios de pago y asignar un monto válido a cada uno.']);
                }

                foreach ($medios as $index => $medioId) {
                    $monto = $montos[$index] ?? 0;
                    if ($monto > 0) {
                        VentaMedioPago::create([
                            'venta_id' => $venta->id,
                            'id_medio_pago' => $medioId,
                            'monto' => $monto,
                        ]);
                    }
                }
            } elseif (is_array($medios)) {
                // Medio de pago individual (aunque el name sea array, solo hay uno)
                $medioId = $medios[0];
                $monto = $validated['total'];

                VentaMedioPago::create([
                    'venta_id' => $venta->id,
                    'id_medio_pago' => $medioId,
                    'monto' => $monto,
                ]);
            }

    
            // Cambiar estado del pedido a Completado
            $pedido = Pedido::findOrFail($validated['id_pedido']);
            $pedido->id_estadoPedido = 1;
            $pedido->save();
    
            return redirect()->route('pedidos.index')->with('success', 'Venta registrada correctamente.');
        } catch (\Exception $e) {
            dd('Error capturado:', $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al registrar la venta: ' . $e->getMessage()]);
        }
    }
    
    
    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $venta = Venta::find($id);

        return view('venta.edit', compact('venta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VentaRequest $request, Venta $venta): RedirectResponse
    {
        $venta->update($request->validated());

        return Redirect::route('ventas.index')
            ->with('success', 'Venta updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Venta::find($id)->delete();

        return Redirect::route('ventas.index')
            ->with('success', 'Venta deleted successfully');
    }


  
}
