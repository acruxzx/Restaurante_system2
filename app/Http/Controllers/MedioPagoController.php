<?php

namespace App\Http\Controllers;

use App\Models\MedioPago;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MedioPagoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MedioPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $medioPagos = MedioPago::paginate();

        return view('medio-pago.index', compact('medioPagos'))
            ->with('i', ($request->input('page', 1) - 1) * $medioPagos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $medioPago = new MedioPago();

        return view('medio-pago.create', compact('medioPago'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedioPagoRequest $request): RedirectResponse
    {
        MedioPago::create($request->validated());

        return Redirect::route('medio-pagos.index')
            ->with('success', 'MedioPago created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $medioPago = MedioPago::find($id);

        return view('medio-pago.show', compact('medioPago'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $medioPago = MedioPago::find($id);

        return view('medio-pago.edit', compact('medioPago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedioPagoRequest $request, MedioPago $medioPago): RedirectResponse
    {
        $medioPago->update($request->validated());

        return Redirect::route('medio-pagos.index')
            ->with('success', 'MedioPago updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        MedioPago::find($id)->delete();

        return Redirect::route('medio-pagos.index')
            ->with('success', 'MedioPago deleted successfully');
    }
}
