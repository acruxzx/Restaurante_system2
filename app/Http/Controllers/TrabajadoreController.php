<?php

namespace App\Http\Controllers;

use App\Models\Trabajadore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TrabajadoreRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TrabajadoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $trabajadores = Trabajadore::paginate();

        return view('trabajadore.index', compact('trabajadores'))
            ->with('i', ($request->input('page', 1) - 1) * $trabajadores->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $trabajadore = new Trabajadore();

        return view('trabajadore.create', compact('trabajadore'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrabajadoreRequest $request): RedirectResponse
    {
        Trabajadore::create($request->validated());

        return Redirect::route('trabajadores.index')
            ->with('success', 'Trabajadore created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $trabajadore = Trabajadore::find($id);

        return view('trabajadore.show', compact('trabajadore'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $trabajadore = Trabajadore::find($id);

        return view('trabajadore.edit', compact('trabajadore'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TrabajadoreRequest $request, Trabajadore $trabajadore): RedirectResponse
    {
        $trabajadore->update($request->validated());

        return Redirect::route('trabajadores.index')
            ->with('success', 'Trabajadore updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Trabajadore::find($id)->delete();

        return Redirect::route('trabajadores.index')
            ->with('success', 'Trabajadore deleted successfully');
    }
}
