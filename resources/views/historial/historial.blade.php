@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center text-white mb-4">Historial de Ventas por Caja</h2>

    <form method="GET" action="{{ route('ventas.historial') }}" class="p-4 mb-4 rounded shadow" style="background-color: #1c1c1c; border: 1px solid #444;">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="id_caja" class="form-label text-white">Seleccionar Caja:</label>
                <select name="id_caja" id="id_caja" class="form-select bg-dark text-white border-gold">
                    <option value="">Todas</option>
                    @foreach ($num_cajas as $caja)
                        <option value="{{ $caja->id }}" {{ request('id_caja') == $caja->id ? 'selected' : '' }}>
                            {{ $caja->caja }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="turno" class="form-label text-white">Seleccionar Turno:</label>
                <select name="turno" id="turno" class="form-select bg-dark text-white border-gold">
                    
                    <option value="dia" {{ Session::get('turno') == 'dia' ? 'selected' : '' }}>Día</option>
                    <option value="noche" {{ Session::get('turno') == 'noche' ? 'selected' : '' }}>Noche</option>
                </select>
            </div>
            

            <div class="col-md-3 mb-3">
                <label for="fecha_inicio" class="form-label text-white">Fecha Inicio:</label>
                <input type="date" name="fecha_inicio" class="form-control bg-dark text-white border-gold" value="{{ request('fecha_inicio') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="fecha_fin" class="form-label text-white">Fecha Fin:</label>
                <input type="date" name="fecha_fin" class="form-control bg-dark text-white border-gold" value="{{ request('fecha_fin') }}">
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-gold me-2">
                <i class="fas fa-search"></i> Consultar
            </button>
            <a href="{{ route('ventas.historial') }}" class="btn btn-outline-light">
                <i class="fas fa-eraser"></i> Limpiar
            </a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle border-gold">
            <thead class="text-gold">
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Caja</th>
                    <th scope="col">Turno</th>
                    <th scope="col">Base Inicial</th>
                    <th scope="col">Total del Turno</th>
                    <th scope="col">Saldo Final</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->fecha }}</td>
                        <td>{{ $num_cajas->get($venta->id_caja)->caja ?? 'Sin Nombre' }}</td>
                        <td>{{ ucfirst($venta->turno ?? 'No disponible') }}</td>
                        <td>${{ number_format($venta->base_inicial, 2) }}</td>
                        <td>${{ number_format($venta->total_turno, 2) }}</td>
                        <td>${{ number_format($venta->saldo_final, 2) }}</td>
                        <td>
                            <a href="{{ route('historial.productos', [$venta->id_caja, $venta->turno, $venta->fecha]) }}" class="btn btn-sm btn-dark">
                                <i class="fas fa-eye"></i> Ver Productos
                            </a>
                               <!-- Nuevo botón para acceder a los totales por medio de pago -->
                            <a href="{{ route('ventas.totales', ['id_caja' => $venta->id_caja, 'turno' => $venta->turno, 'fecha' => $venta->fecha]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-dollar-sign"></i> Totales por Medio de Pago
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-white">No se encontraron resultados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Estilos personalizados -->
<style>
    .btn-gold {
        background-color: #d4af37;
        color: #1c1c1c;
        border: none;
    }

    .btn-gold:hover {
        background-color: #c79c2a;
        color: white;
    }

    .text-gold {
        color: #d4af37;
    }

    .border-gold {
        border: 1px solid #d4af37;
    }
</style>
@endsection
