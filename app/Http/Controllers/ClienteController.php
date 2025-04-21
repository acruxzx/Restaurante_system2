<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $clientes = Cliente::paginate();

        return view('cliente.index', compact('clientes'))
            ->with('i', ($request->input('page', 1) - 1) * $clientes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $cliente = new Cliente();

        return view('cliente.create', compact('cliente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClienteRequest $request): RedirectResponse
    {
        Cliente::create($request->validated());

        return Redirect::route('pedidos.create')
            ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $cliente = Cliente::find($id);

        return view('cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $cliente = Cliente::find($id);
    
        return view('cliente.edit', compact('cliente'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(ClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        // Actualizamos el cliente con los datos validados
        $cliente->update($request->validated());
    
        // Redirigimos al show de ese cliente después de la actualización
        return redirect()->route('clientes.show', $cliente->id)
            ->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy($id)
    {
        // Buscar el cliente
        $cliente = Cliente::find($id);
    
        // Verificar si el cliente tiene pedidos asociados
        $pedidos = $cliente->pedidos;
    
        // Si tiene pedidos, mostrar un mensaje con la cantidad y las fechas
        if ($pedidos->count() > 0) {
            return view('cliente.confirmar_eliminacion', compact('cliente', 'pedidos'));
        }
    
        // Si no tiene pedidos, proceder a eliminar el cliente
        $cliente->delete();
    
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente');
    }
}
