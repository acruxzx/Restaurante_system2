<?php

namespace App\Http\Controllers;

use App\Models\NumCaja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\NumCajaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class NumCajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el estado desde la petición, si no se proporciona, se filtra por "activa" por defecto
        $estado = $request->get('estado', 'activa');
        
        // Filtrar las cajas por estado
        $numCajas = NumCaja::where('estado', $estado)->paginate(20);
    
        return view('num-caja.index', compact('numCajas', 'estado'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $numCaja = new NumCaja();

        return view('num-caja.create', compact('numCaja'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NumCajaRequest $request): RedirectResponse
    {
        $existeCaja = NumCaja::where('caja', $request->caja)->exists();
    
        if ($existeCaja) {
            return Redirect::back()
                ->withErrors(['caja' => 'El nombre de la caja ya existe. Por favor, elija otro.'])
                ->withInput();
        }
    
        // Crear la caja con el estado "activa"
        NumCaja::create(array_merge($request->validated(), ['estado' => 'activa']));
    
        return Redirect::route('num-cajas.index')
            ->with('success', 'Caja creada exitosamente.');
    }
    


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $numCaja = NumCaja::find($id);

        return view('num-caja.show', compact('numCaja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $numCaja = NumCaja::find($id);

        return view('num-caja.edit', compact('numCaja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
{
    $request->validate([
        'caja' => [
            'required', 
            'string', 
            'max:255', 
            'unique:num_caja,caja,' . $id,  // Asegura que el nombre de la caja sea único, excepto el que se está actualizando
        ],
        'base_dia' => [
            'required',
            'numeric',  // Valida que base_inicial sea un número
            'gt:0',  // Asegura que el valor de base_inicial sea mayor que 0
        ],
        'base_noche' => [
            'required',
            'numeric',  // Valida que base_inicial sea un número
            'gt:0',  // Asegura que el valor de base_inicial sea mayor que 0
        ],
        'estado' => [
            'required',
            'in:activa,inactiva',  // Valida que el estado sea "activa" o "inactiva"
        ]
    ], [
        // Mensajes personalizados de validación
        'base_dia.required' => 'La base inicial es obligatoria.',
        'base_dia.numeric' => 'La base inicial debe ser un número.',
        'base_dia.gt' => 'La base inicial debe ser mayor que 0.',
        'base_noche.required' => 'La base inicial es obligatoria.',
        'base_noche.numeric' => 'La base inicial debe ser un número.',
        'base_noche.gt' => 'La base inicial debe ser mayor que 0.',
        'estado.required' => 'El estado es obligatorio.',
        'estado.in' => 'El estado debe ser "activa" o "inactiva".',
    ]);
    
    // Buscar la caja en la base de datos
    $numCaja = NumCaja::findOrFail($id);
    
    // Actualizar los datos con la solicitud recibida
    $numCaja->update([
        'caja' => $request->input('caja'),
        'base_dia' => $request->input('base_dia'),
        'base_noche' => $request->input('base_noche'),
        'estado' => $request->input('estado'),  // Actualizar el estado
    ]);
    
    // Redirigir con mensaje de éxito
    return redirect()->route('num-cajas.index')
        ->with('success', 'Caja actualizada exitosamente.');
}

    
    public function destroy(NumCaja $numCaja): RedirectResponse
    {
        // Cambiar el estado de la caja a "inactiva"
        $numCaja->update(['estado' => 'inactiva']);
        
        return Redirect::route('num-cajas.index')
            ->with('success', 'Caja desactivada exitosamente.');
    }
    

}
