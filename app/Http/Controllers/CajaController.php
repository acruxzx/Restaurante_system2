<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CajaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $cajas = Caja::paginate();

        return view('caja.index', compact('cajas'))
            ->with('i', ($request->input('page', 1) - 1) * $cajas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $caja = new Caja();

        return view('caja.create', compact('caja'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CajaRequest $request): RedirectResponse
    {
        Caja::create($request->validated());

        return Redirect::route('cajas.index')
            ->with('success', 'Caja created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $caja = Caja::find($id);

        return view('caja.show', compact('caja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $caja = Caja::find($id);

        return view('caja.edit', compact('caja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CajaRequest $request, Caja $caja): RedirectResponse
    {
        $caja->update($request->validated());

        return Redirect::route('cajas.index')
            ->with('success', 'Caja updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Caja::find($id)->delete();

        return Redirect::route('cajas.index')
            ->with('success', 'Caja deleted successfully');
    }


     // Mostrar vista para abrir caja con base inicial
     public function abrirCajaView()
     {
         $numCajas = NumCaja::all();
         return view('caja.abrir', compact('numCajas'));
     }
 
     // Acción para abrir la caja
     public function abrirCaja(Request $request)
     {
         $validatedData = $request->validate([
             'id_num_caja' => 'required|exists:num_caja,id',
             'base_inicial' => 'required|numeric|min:0',
         ]);
 
         $caja = new Caja();
         $caja->id_num_caja = $request->id_num_caja;
         $caja->id_trabajador = Auth::id();
         $caja->total_turno = 0;
         $caja->saldo_final = $request->base_inicial; // Inicializa con la base inicial
         $caja->fecha_inicio = Carbon::now();
         $caja->estado = 'abierto';
         $caja->save();
 
         return redirect()->route('caja.index')->with('success', 'Turno de caja iniciado con éxito');
     }
 
     // Calcular ventas del turno al cerrar la caja
     public function cerrarCaja($id)
     {
         $caja = Caja::find($id);
         
         if ($caja && $caja->estado === 'abierto') {
             $ventas = Venta::where('id_caja', $caja->id)->sum('total');
             $caja->total_turno = $ventas;
             $caja->saldo_final = $caja->base_inicial + $ventas;
             $caja->fecha_fin = Carbon::now();
             $caja->estado = 'cerrado';
             $caja->save();
 
             return redirect()->route('caja.index')->with('success', 'Caja cerrada exitosamente');
         }
 
         return redirect()->route('caja.index')->with('error', 'Error al cerrar la caja');
     }
}
