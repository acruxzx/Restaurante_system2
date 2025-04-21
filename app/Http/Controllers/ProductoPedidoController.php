<?php

namespace App\Http\Controllers;

use App\Models\Precio;
use App\Models\Cliente;
use App\Models\ProductoPedido;
use App\Models\Pedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoPedidoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ProductoPedidoController extends Controller
{


    public function index(Request $request)
    {
        $query = ProductoPedido::query();
    
        // Obtener las fechas desde la solicitud, si existen
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
    
        // Filtrar por fecha si se proporcionaron
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }
    
        $productoPedidos = $query->paginate(10); // Cambia la paginación según necesites
    
        return view('producto-pedido.index', compact('productoPedidos'))->with('i');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($pedidoId): View
    {
        $pedido = Pedido::find($pedidoId);

    if (!$pedido) {
        return redirect()->route('pedidos.index')->with('error', 'Pedido no encontrado.');
    }
        $productoPedido = new ProductoPedido();
        $precios = Precio::where('estado', 'activo')->get();
 // Obtener los productos que ya están en el pedido
 $productosEnPedido = ProductoPedido::with(['precio.producto'])
 ->where('id_pedido', $pedidoId)
 ->get();
        return view('producto-pedido.create', compact('productoPedido','productosEnPedido','precios','pedido'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'id_pedido' => 'required|exists:pedidos,id',
        'productos' => 'required|array',
        'productos.*.id_precio' => 'required|exists:precios,id',
        'productos.*.cantidad' => 'required|integer|min:1',
        'productos.*.descuento' => 'nullable|numeric|min:0|max:100', // Asegúrate de que el descuento esté en un rango válido
        'productos.*.observacion' => 'nullable|string',
    ]);

    foreach ($validated['productos'] as $producto) {
        // Si el descuento no está presente, asignamos 0 por defecto
        $descuento = isset($producto['descuento']) ? $producto['descuento'] : 0;

        // Guardamos el producto en la base de datos con el descuento
        ProductoPedido::create([
            'id_pedido' => $validated['id_pedido'],
            'id_precio' => $producto['id_precio'],
            'cantidad' => $producto['cantidad'],
            'descuento' => $descuento, // Guardamos el descuento en la base de datos
            'observacion' => $producto['observacion']
        ]);
    }

    return response()->json(['success' => 'El carrito fue confirmado con éxito.']);
}

    
    


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        // Encuentra el ProductoPedido por ID
        $productoPedido = ProductoPedido::with(['pedido','precio.producto', 'pedido.cliente'])->findOrFail($id);
    
        return view('producto-pedido.show', compact('productoPedido'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $productoPedido = ProductoPedido::find($id);
        $clientes= Cliente::all();
        return view('producto-pedido.edit', compact('productoPedido','clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoPedidoRequest $request, ProductoPedido $productoPedido): RedirectResponse
    {
        $productoPedido->update($request->validated());

        return Redirect::route('producto-pedidos.index')
            ->with('success', 'ProductoPedido updated successfully');
    }

    public function destroy($producto_pedido): RedirectResponse
    {
        // Encontrar el producto-pedido usando el ID de la relación
        $productoPedido = ProductoPedido::find($producto_pedido);
    
        // Si no se encuentra, devolver un error
        if (!$productoPedido) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }
    
        // Eliminar la relación
        $productoPedido->delete();
    
        // Devolver una respuesta JSON exitosa
        return response()->json(['success' => 'Producto eliminado correctamente']);
    }
    
}
