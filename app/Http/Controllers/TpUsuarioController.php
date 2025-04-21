<?php

namespace App\Http\Controllers;

use App\Models\TpUsuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TpUsuarioRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TpUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tpUsuarios = TpUsuario::paginate();

        return view('tp-usuario.index', compact('tpUsuarios'))
            ->with('i', ($request->input('page', 1) - 1) * $tpUsuarios->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tpUsuario = new TpUsuario();

        return view('tp-usuario.create', compact('tpUsuario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TpUsuarioRequest $request): RedirectResponse
    {
        TpUsuario::create($request->validated());

        return Redirect::route('tp-usuarios.index')
            ->with('success', 'TpUsuario created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $tpUsuario = TpUsuario::find($id);

        return view('tp-usuario.show', compact('tpUsuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tpUsuario = TpUsuario::find($id);

        return view('tp-usuario.edit', compact('tpUsuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TpUsuarioRequest $request, TpUsuario $tpUsuario): RedirectResponse
    {
        $tpUsuario->update($request->validated());

        return Redirect::route('tp-usuarios.index')
            ->with('success', 'TpUsuario updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        TpUsuario::find($id)->delete();

        return Redirect::route('tp-usuarios.index')
            ->with('success', 'TpUsuario deleted successfully');
    }
}
