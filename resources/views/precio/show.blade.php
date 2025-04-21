@extends('layouts.app')

@section('template_title')
    Detalles del Precio
@endsection

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-3" style="background-color: #1a1a1a; color: #f5f5f5;">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #111111;">
                        <div>
                            <h4 class="mb-1" style="color: #d4af37;">Detalles del Precio</h4>
                            <p class="mb-0">Producto: <strong style="color: #ffffff;">{{ $precio->producto->nombre }}</strong></p>
                        </div>
                        <a href="{{ route('precios.index') }}" class="btn btn-outline-light rounded-pill">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                Precio Actual: 
                                <span class="badge" style="background-color: #d4af37; color: #111111; font-size: 1rem;">
                                    ${{ number_format($precio->precio, 2) }}
                                </span>
                            </h5>
                        </div>

                        <h6 class="mb-3" style="color: #d4af37;">Ventas Asociadas</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle" style="border-color: #333;">
                                <thead style="background-color: #111111; color: #d4af37;">
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Mes</th>
                                        <th class="text-center">Año</th>
                                        <th class="text-center">Total Vendido</th>
                                        <th class="text-center">Total Venta ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventasPorFecha as $venta)
                                        <tr>
                                            <td class="text-center">{{ $venta->fecha }}</td>
                                            <td class="text-center">{{ $venta->mes }}</td>
                                            <td class="text-center">{{ $venta->anio }}</td>
                                            <td class="text-center">{{ $venta->total_vendido }}</td>
                                            <td class="text-center" style="color: #d4af37;">
                                                ${{ number_format($venta->total_venta, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $ventasPorFecha->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
