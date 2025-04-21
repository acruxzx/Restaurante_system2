<?php

namespace App\Http\Controllers;

use App\Models\Precio;
use App\Models\Producto;
use App\Models\Tamano;
use App\Models\TpProducto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PrecioRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function index(Request $request): View
     {
         $busqueda = $request->input('busqueda');
         $estado = $request->input('estado', 'activo');
         $tipoProductoId = $request->input('tipo_producto');
     
         $precios = Precio::where('estado', $estado)
             ->when($busqueda, function ($query, $busqueda) {
                 $query->whereHas('producto', function ($q) use ($busqueda) {
                     $q->where('nombre', 'LIKE', '%' . $busqueda . '%')
                       ->orWhere('descripcion', 'LIKE', '%' . $busqueda . '%');
                 });
             })
             ->when($tipoProductoId, function ($query, $tipoProductoId) {
                 $query->whereHas('producto.tpProducto', function ($q) use ($tipoProductoId) {
                     $q->where('id', $tipoProductoId);
                 });
             })
             ->with(['producto', 'producto.tpProducto', 'tamanos'])
             ->latest('id')
             ->paginate(15);
     
         $tiposProducto = TpProducto::all(); // Obtén los tipos de producto disponibles
     
         $data = [
             'busqueda' => $busqueda,
             'estado' => $estado,
             'tipo_producto' => $tipoProductoId,
         ];
     
         return view('precio.index', compact('precios', 'data', 'tiposProducto'))
             ->with('i', (request()->input('page', 1) - 1) * 15);
     }
     
     public function activar($id)
{
    $precio = Precio::findOrFail($id);
    $precio->estado = 'activo';
    $precio->save();

    return redirect()->route('precios.index')->with('success', 'Producto activado correctamente.');
}
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $precio = new Precio();
        $producto= Producto::all();
        $tp_productos= TpProducto::all();
        $tamaños= Tamano::all();
        return view('precio.create', compact('precio','producto','tp_productos','tamaños'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'id_tp_productos' => 'required|exists:_tp_productos,id', // Asegúrate de que el ID del tipo de producto exista
            'id_tamaño' => 'required|exists:tamanos,id', // Validación para el tamaño
            'precio' => 'required|numeric|min:0'
        ],
        [
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.min' => 'El precio no puede ser negativo.',
        ]);
    
        // Validar si ya existe un producto con el mismo nombre, tipo, tamaño y precio
       $existeProducto = Producto::where('nombre', $request->nombre_producto)
                          ->where('id_tp_productos', $request->id_tp_productos)
                          ->whereHas('precios', function ($query) use ($request) {
                              $query->where('id_tamanos', $request->id_tamaño)
                                    ->where('precio', $request->precio);
                          })
                          ->exists();
        if ($existeProducto) {
            return back()->withErrors(['nombre_producto' => 'Ya existe un producto con ese nombre, tipo, tamaño y precio.']);
        }
    
        // Crear un nuevo producto
        $producto = new Producto();
        $producto->nombre = $request->nombre_producto;
        $producto->descripcion = $request->descripcion;
        $producto->id_tp_productos = $request->id_tp_productos;
        $producto->save(); // Guardar el producto
        
        // Crear el precio para el nuevo producto
        $precio = new Precio();
        $precio->id_productos = $producto->id; // Asignar el ID del producto recién creado
        $precio->id_tamanos = $request->id_tamaño; // Usar el nombre correcto del campo
        $precio->precio = $request->precio;
        $precio->estado = 1; // Establecer el estado como activo (1)
        $precio->save(); // Guardar el precio
        
        return redirect()->route('precios.index')->with('success', 'Producto y precio agregados correctamente.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Obtener el precio específico
        $precio = Precio::findOrFail($id);
    
        // Obtener las ventas relacionadas con este precio, agrupadas por fecha
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
            ->where('precios.id', $id)  // Filtrar por el precio específico
            ->where('estado_pedidos.estado', 'completado')  // Solo pedidos completados
            ->where('precios.estado', 'activo')  // Solo precios activos
            ->groupBy(DB::raw('DATE(ventas.created_at)'), DB::raw('MONTH(ventas.created_at)'), DB::raw('YEAR(ventas.created_at)'))
            ->orderByDesc('fecha')  // Ordenar por fecha descendente
            ->paginate(15);  // Paginación
    
        // Retornar a la vista con los datos del precio y las ventas agrupadas
        return view('precio.show', compact('precio', 'ventasPorFecha'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $precio = Precio::find($id);
        $productos= Precio::all();
        $tp_producto= TpProducto::all();
        $tamaños= Tamano::all();
        return view('precio.edit', compact('precio','productos','tp_producto','tamaños'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Precio $precio): RedirectResponse
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'id_tp_productos' => 'required|exists:_tp_productos,id',
            'id_tamaños' => 'required|exists:tamanos,id',
            'precio' => 'required|numeric|min:0',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción no debe exceder los 255 caracteres.',
            
            'id_tp_productos.required' => 'El campo tipo de producto es obligatorio.',
            'id_tp_productos.exists' => 'El tipo de producto seleccionado no existe en la base de datos.',
            
            'id_tamaños.required' => 'El campo tamaño es obligatorio.',
            'id_tamaños.exists' => 'El tamaño seleccionado no existe en la base de datos.',
            
            'precio.required' => 'El campo precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.min' => 'El precio no puede ser menor que 0.',
        ]);
    
        // Paso 1: Actualizar los datos del producto asociado
        $producto = $precio->producto;
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_tp_productos' => $request->id_tp_productos,
        ]);
    
        // Paso 2: Desactivar el precio actual
        $precio->update(['estado' => 'inactivo']);
    
        // Paso 3: Crear un nuevo precio con el valor actualizado
        Precio::create([
            'id_productos' => $producto->id,
            'precio' => $request->precio,
            'id_tamanos' => $request->id_tamaños, // Asigna el tamaño
            'estado' => 'activo',
        ]);
    
        return redirect()->route('precios.index')
            ->with('success', 'Producto y precio actualizados correctamente.');
    }
    

    public function inactivar($id)
    {
        // Buscar el precio y cambiar su estado a inactivo
        $precio = Precio::findOrFail($id);
        $precio->update(['estado' => 'inactivo']); // Ajusta el campo 'estado' según tu modelo
    
        return redirect()->route('precios.index')
            ->with('success', 'El precio ha sido inactivado correctamente.');
    }
}
