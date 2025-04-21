<?php

namespace App\Http\Controllers;

use App\Models\TpProducto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TpProductoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TpProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tpProductos = TpProducto::paginate();

        return view('tp-producto.index', compact('tpProductos'))
            ->with('i', ($request->input('page', 1) - 1) * $tpProductos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tpProducto = new TpProducto();

        return view('tp-producto.create', compact('tpProducto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar y guardar el tipo de producto
        $request->validate([
            'tipo_producto' => 'required|string|max:255',
        ]);
    
        // Guardar el tipo de producto
        $tipoProducto = new TpProducto();
        $tipoProducto->tipo_producto = $request->tipo_producto;
        $tipoProducto->save();
    
        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('precios.create')->with('success', 'Tipo de producto agregado correctamente');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $tpProducto = TpProducto::find($id);

        return view('tp-producto.show', compact('tpProducto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tpProducto = TpProducto::find($id);

        return view('tp-producto.edit', compact('tpProducto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TpProductoRequest $request, TpProducto $tpProducto): RedirectResponse
    {
        $tpProducto->update($request->validated());

        return Redirect::route('tp-productos.index')
            ->with('success', 'TpProducto updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        TpProducto::find($id)->delete();

        return Redirect::route('tp-productos.index')
            ->with('success', 'TpProducto deleted successfully');
    }
}
