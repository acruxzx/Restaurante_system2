<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Precio;
use App\Models\TpProducto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $busqueda = $request->input('busqueda'); // Obtenemos la búsqueda

    // Realizamos la búsqueda en la base de datos
    if ($busqueda) {
        $productos = Producto::where('nombre', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('descripcion', 'LIKE', '%' . $busqueda . '%') //  buscar también por descripción
            ->latest('id')
            ->paginate(10);
    } else {
        // Si no hay búsqueda, paginamos todos los productos
        $productos = Producto::latest('id')->paginate(10);
    }

    $data = [
        'busqueda' => $busqueda,
    ];

    return view('producto.index', compact('productos', 'data'))->with('i');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $producto = new Producto();
        $tp_producto= TpProducto::all();
        $precio= Precio::all();
        

        return view('producto.create', compact('producto','tp_producto','precio'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request): JsonResponse
    {

        try{

            $tp_producto= $request->input('id_tp_productos');
            $producto= new Producto();
            $producto->id_tp_productos= $tp_producto;
            $producto->nombre=$request->input('nombre');
            $producto->descripcion=$request->input('descripcion');
            $producto->save();
            
            return response()->json(['success' => 'El producto se ha actualizado exitosamente .']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un problema al agregar el producto. Por favor, intenta de nuevo.'], 500);
        }
        /*
        Producto::create($request->validated());

        return Redirect::route('productos.index')
            ->with('success', 'Producto created successfully.');
            */
    }


    /**
     * Display the specified resource.
     */
    public function show($id): View
{
    $producto = Producto::findOrFail($id);

    // Obtener las ventas agrupadas por día, mes o año para este producto
    $ventasPorFecha = DB::table('producto_pedidos')
        ->join('pedidos', 'producto_pedidos.id_pedido', '=', 'pedidos.id')
        ->join('estado_pedidos', 'pedidos.id_estadoPedido', '=', 'estado_pedidos.id')
        ->join('precios', 'producto_pedidos.id_precio', '=', 'precios.id')
        ->join('productos', 'precios.id_productos', '=', 'productos.id')
        ->join('ventas', 'pedidos.id', '=', 'ventas.id_pedido')
        ->select(
            DB::raw('DATE(ventas.created_at) as fecha'),  // Agrupar por día
            DB::raw('MONTH(ventas.created_at) as mes'),   // Agrupar por mes
            DB::raw('YEAR(ventas.created_at) as anio'),   // Agrupar por año
            DB::raw('SUM(producto_pedidos.cantidad) as total_vendido'),
            DB::raw('SUM(producto_pedidos.cantidad * precios.precio) as total_venta') // Total monetario
        )
        ->where('productos.id', $id)  // Filtrar por el producto específico
        ->where('estado_pedidos.estado', 'completado')  // Solo pedidos completados
        ->where('precios.estado', 'activo')  // Solo precios activos
        ->groupBy(DB::raw('DATE(ventas.created_at)'), DB::raw('MONTH(ventas.created_at)'), DB::raw('YEAR(ventas.created_at)'))
        ->orderByDesc('fecha')  // Ordenar por fecha descendente
        ->  paginate(15); 

    return view('producto.show', compact('producto', 'ventasPorFecha'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $producto = Producto::find($id);
        $tp_producto= TpProducto::all();
        return view('producto.edit', compact('producto','tp_producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, Producto $producto): JsonResponse
    {
        try {
            // Actualiza el producto con los datos validados
            $producto->update($request->validated());
    
            // Retorna una respuesta de éxito con una URL de redirección
            return response()->json([
                'success' => 'Producto actualizado exitosamente.',
                'redirect' => route('productos.index'), // URL de redirección
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un problema al actualizar el producto. Por favor, intenta de nuevo.'], 500);
        }
    }

    public function destroy($id): RedirectResponse
    {
        Producto::find($id)->delete();

        return Redirect::route('productos.index')
            ->with('success', 'Producto deleted successfully');
    }
}
