<?php

namespace App\Http\Controllers;

use App\Models\Tamano;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TamanoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TamanoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tamanos = Tamano::paginate();

        return view('tamano.index', compact('tamanos'))
            ->with('i', ($request->input('page', 1) - 1) * $tamanos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tamano = new Tamano();

        return view('tamano.create', compact('tamano'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TamanoRequest $request): RedirectResponse
    {
        Tamano::create($request->validated());

        return Redirect::route('precios.create')
            ->with('success', 'Tamaño creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $tamano = Tamano::find($id);

        return view('tamano.show', compact('tamano'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tamano = Tamano::find($id);

        return view('tamano.edit', compact('tamano'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TamanoRequest $request, Tamano $tamano): RedirectResponse
    {
        $tamano->update($request->validated());

        return Redirect::route('tamanos.index')
            ->with('success', 'Tamano updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Tamano::find($id)->delete();

        return Redirect::route('tamanos.index')
            ->with('success', 'Tamano deleted successfully');
    }
}
