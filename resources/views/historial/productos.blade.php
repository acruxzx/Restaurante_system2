@extends('layouts.app')

@section('template_title')
    Productos del Turno
@endsection

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h3 class="text-gold">Productos Vendidos</h3>
        <p class="text-white">Caja: <strong>{{ $id_caja }}</strong> | Turno: <strong>{{ $turno }}</strong> | Fecha: <strong>{{ $fecha }}</strong></p>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-dark table-bordered table-hover align-middle shadow-lg rounded">
            <thead class="text-gold">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->cantidad }}</td>
                        <td>${{ number_format($producto->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Return Button -->
    <div class="d-flex justify-content-center mt-4">
        <a href="{{ route('ventas.historial') }}" class="btn btn-outline-gold">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

@endsection

<!-- Estilos personalizados -->
<style>
    .text-gold {
        color: #d4af37;
    }

    .btn-outline-gold {
        border-color: #d4af37;
        color: #d4af37;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-outline-gold:hover {
        background-color: #d4af37;
        color: #1c1c1c;
    }

    .table-dark {
        background-color: #1c1c1c;
        color: white;
    }

    .table-dark th, .table-dark td {
        border-color: #d4af37;
    }

    .table-hover tbody tr:hover {
        background-color: #333;
    }

    .table-responsive {
        margin-top: 20px;
    }
</style>
