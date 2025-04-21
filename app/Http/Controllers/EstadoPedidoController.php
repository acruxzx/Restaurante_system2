<?php

namespace App\Http\Controllers;

use App\Models\EstadoPedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EstadoPedidoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EstadoPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $estadoPedidos = EstadoPedido::paginate();

        return view('estado-pedido.index', compact('estadoPedidos'))
            ->with('i', ($request->input('page', 1) - 1) * $estadoPedidos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $estadoPedido = new EstadoPedido();

        return view('estado-pedido.create', compact('estadoPedido'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstadoPedidoRequest $request): RedirectResponse
    {
        EstadoPedido::create($request->validated());

        return Redirect::route('estado-pedidos.index')
            ->with('success', 'EstadoPedido created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $estadoPedido = EstadoPedido::find($id);

        return view('estado-pedido.show', compact('estadoPedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $estadoPedido = EstadoPedido::find($id);

        return view('estado-pedido.edit', compact('estadoPedido'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstadoPedidoRequest $request, EstadoPedido $estadoPedido): RedirectResponse
    {
        $estadoPedido->update($request->validated());

        return Redirect::route('estado-pedidos.index')
            ->with('success', 'EstadoPedido updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        EstadoPedido::find($id)->delete();

        return Redirect::route('estado-pedidos.index')
            ->with('success', 'EstadoPedido deleted successfully');
    }
}
