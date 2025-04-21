@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <!-- Título -->
        <div class="row mb-4">
            <div class="col">
                <h3 class="text-dark"><i class="fas fa-money-check-alt" style="color: #ffd700;"></i> Totales por Medio de Pago</h3>
                <p class="text-muted">Visualiza los totales de ventas por medio de pago, según los filtros aplicados.</p>
            </div>
        </div>

        <!-- Filtros Aplicados -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card" style="border: 1px solid #ffd700;">
                    <div class="card-header" style="background-color: #000; color: #ffd700;">
                        <strong>Filtros Aplicados</strong>
                    </div>
                    <div class="card-body" style="background-color: #f9f9f9;">
                        <ul class="list-unstyled">
                            <li><strong>Fecha:</strong> {{ $fecha->format('d/m/Y') }}</li>
                            <li><strong>Turno:</strong> {{ ucfirst($turno) }}</li>
                            @foreach ($cajas as $caja)
                                <li><strong>Caja:</strong> {{ $caja->caja }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Totales por Medio de Pago -->
        <div class="row">
            <div class="col">
                <div class="card" style="border: 1px solid #ffd700;">
                    <div class="card-header" style="background-color: #000; color: #ffd700;">
                        <strong>Totales por Medio de Pago</strong>
                    </div>
                    <div class="card-body" style="background-color: #f9f9f9;">
                        <table class="table table-hover table-bordered">
                            <thead style="background-color: #000; color: #ffd700;">
                                <tr>
                                    <th>Medio de Pago</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($totalesPorMedioPago as $medioPago => $total)
                                    <tr style="color: #333;">
                                        <td>{{ $medioPago }}</td>
                                        <td class="text-right" style="color: #000; font-weight: bold;">
                                            {{ number_format($total, 2) }}
                                        </td>
                                    
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de Regreso -->
        <div class="row mt-4">
            <div class="col">
                <a href="{{ route('ventas.historial', [
                    'id_caja' => $id_caja,
                    'fecha' => $fecha->format('Y-m-d'),
                    'turno' => $turno
                ]) }}" class="btn" style="background-color: #ffd700; color: #000; border: none;">
                    <i class="fas fa-arrow-left"></i> Regresar al Historial
                </a>
            </div>
        </div>
    </div>
@endsection
