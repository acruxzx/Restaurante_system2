<?php

namespace App\Http\Controllers;

use App\Models\TpPedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TpPedidoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TpPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tpPedidos = TpPedido::paginate();

        return view('tp-pedido.index', compact('tpPedidos'))
            ->with('i', ($request->input('page', 1) - 1) * $tpPedidos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tpPedido = new TpPedido();

        return view('tp-pedido.create', compact('tpPedido'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TpPedidoRequest $request): RedirectResponse
    {
        TpPedido::create($request->validated());

        return Redirect::route('pedidos.create')
            ->with('success', 'TpPedido creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $tpPedido = TpPedido::find($id);

        return view('tp-pedido.show', compact('tpPedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tpPedido = TpPedido::find($id);

        return view('tp-pedido.edit', compact('tpPedido'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TpPedidoRequest $request, TpPedido $tpPedido): RedirectResponse
    {
        $tpPedido->update($request->validated());

        return Redirect::route('tp-pedidos.index')
            ->with('success', 'TpPedido updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        TpPedido::find($id)->delete();

        return Redirect::route('tp-pedidos.index')
            ->with('success', 'TpPedido deleted successfully');
    }
}
