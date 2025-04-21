<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\MedioPago;
use App\Models\ProductoPedido;
use App\Models\TpPedido;
use App\Models\EstadoPedido;
use App\Models\Cliente;
use App\Models\Trabajadore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PedidoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Recuperar los valores de los filtros desde la solicitud
        $id = $request->input('id'); // Número de pedido
        $cliente = $request->input('cliente'); // Nombre del cliente
        $fechaInicio = $request->input('fecha_inicio'); // Fecha de inicio
        $fechaFin = $request->input('fecha_fin'); // Fecha de fin
        $estado = $request->input('estado'); // Estado del pedido
        $trabajador = $request->input('trabajador'); // Trabajador
        $tipo = $request->input('tipo');
    
        // Construir la consulta de pedidos con las relaciones necesarias
        $query = Pedido::with([
            'estadoPedido', 
            'userTrabajador', 
            'cliente', 
            'productoPedidos.precio' // Incluir productos y precios
        ]);
    
        // Aplicar filtros
        if ($id) {
            $query->where('id', $id);
        }
        if ($cliente) {
            $query->whereHas('cliente', function ($q) use ($cliente) {
                $q->where('nombre', 'LIKE', '%' . $cliente . '%');
            });
        }
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }
        if ($estado) {
            $query->whereHas('estadoPedido', function ($q) use ($estado) {
                $q->where('estado', $estado);
            });
        }
        
        if ($trabajador) {
            $query->where('id_trabajador', $trabajador); 
        }
        if ($tipo) {
            $query->where('id_tp_pedido', $tipo); 
        }
    
        // Obtener los tipos de pedido y los trabajadores
        $tipo = TpPedido::all();
        $trabajadores = Trabajadore::all();
    
        // Ordenar y paginar resultados
        $pedidos = $query->orderBy('created_at', 'desc')
    ->orderByRaw("FIELD(id_estadoPedido, (SELECT id FROM estado_pedidos WHERE estado = 'Pendiente')) DESC")
    ->paginate();

    
        // Calcular el total de cada pedido
        foreach ($pedidos as $pedido) {
            $totalFactura = $pedido->productoPedidos->sum(function ($productoPedido) {
                $precioUnitario = $productoPedido->precio->precio ?? 0;
                $cantidad = $productoPedido->cantidad;
                $descuento = $productoPedido->descuento ?? 0;  // Si no hay descuento, será 0
    
                // Aplicar el descuento al precio
                $precioConDescuento = $precioUnitario * (1 - $descuento / 100);
    
                return $precioConDescuento * $cantidad;
            });
    
            // Redondear el total a 2 decimales
            $pedido->total_factura = round($totalFactura, 2);
        }

        // Retornar la vista con los datos
        return view('pedido.index', compact('pedidos', 'trabajadores', 'tipo'))
            ->with('i', ($request->input('page', 1) - 1) * $pedidos->perPage());
    }
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pedido = new Pedido();
       $trabajador= Trabajadore::all();
        $tp_pedido= TpPedido::all();
        $estado= EstadoPedido::all();
        $clientes= Cliente::all();
       

        return view('pedido.create', compact('pedido','tp_pedido','estado','clientes','trabajador'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PedidoRequest $request): RedirectResponse
    {
        // Crear el pedido y obtener la instancia para capturar su ID
        $pedido = Pedido::create($request->validated());
    
        // Redirigir a la ruta de asignación de productos, pasando el ID del pedido recién creado
        return Redirect::route('producto-pedidos.create', ['pedido' => $pedido->id])
            ->with('success', 'Pedido creado exitosamente. Ahora puede asignar productos.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id): View {
        $pedido = Pedido::with([
            'productoPedidos.precio.producto', 
            'cliente', 
            'venta.mediosPago' // Incluye la relación de venta con medio de pago
        ])->findOrFail($id);
    
        return view('pedido.show', compact('pedido'));
        
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $pedido = Pedido::find($id);
        $tp_pedido= TpPedido::all();
        $estado= EstadoPedido::all();
        $clientes= Cliente::all();
        $trabajador= Trabajadore::all();

        return view('pedido.edit', compact('pedido','tp_pedido','estado','clientes','trabajador'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PedidoRequest $request, Pedido $pedido): RedirectResponse
    {
        $pedido->update($request->validated());

        return Redirect::route('pedidos.index')
            ->with('success', 'Pedido actualizado correctamente');
    }

    public function destroy($id): RedirectResponse
    {
        Pedido::find($id)->delete();

        return Redirect::route('pedidos.index')
            ->with('success', 'Pedido eliminado correctamente');
    }
    public function completar($id)
    {
        try {
            $pedido = Pedido::findOrFail($id);
            $estadoCompletado = EstadoPedido::where('estado', 'Completado')->first();
    
            // Actualiza el estado del pedido
            $pedido->id_estadoPedido = $estadoCompletado->id;
            $pedido->save();
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
}
