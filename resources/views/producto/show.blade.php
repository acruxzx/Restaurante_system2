@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-dark font-weight-bold">{{ $producto->nombre }}</h1>
        <a href="{{ route('productos.index') }}" class="btn btn-outline-dark rounded-0">Volver a Productos</a>
    </div>

    <h3 class="text-dark mb-4">Ventas del Producto</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped factura-table">
            <thead class="bg-dark text-white">
                <tr>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Total Vendido</th>
                    <th class="text-center">Total de Venta</th> <!-- Columna para mostrar el total monetario -->
                </tr>
            </thead>
            <tbody>
                @forelse($ventasPorFecha as $venta)
                    <tr class="text-center">
                        <td>
                            @if ($venta->fecha)
                                {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }} <!-- Formato por día -->
                            @elseif ($venta->mes)
                                {{ \Carbon\Carbon::parse("{$venta->anio}-{$venta->mes}-01")->format('F Y') }} <!-- Formato por mes -->
                            @else
                                {{ $venta->anio }} <!-- Formato por año -->
                            @endif
                        </td>
                        <td>{{ $venta->total_vendido }}</td>
                        <td>{{ number_format($venta->total_venta, 2) }} $</td> <!-- Mostrar el total monetario con formato -->
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="3">No hay ventas registradas para este producto.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .factura-table th, .factura-table td {
            padding: 15px 20px;
            text-align: center;
        }
        .factura-table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }
        .factura-table th {
            background-color: #343a40;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
        }
        .factura-table td {
            background-color: #f9f9f9;
            font-size: 14px;
        }
        .factura-table tr:nth-child(even) {
            background-color: #f1f1f1;
        }
        .factura-table tr:hover {
            background-color: #f0f0f0;
        }
        .factura-table td {
            border-top: 1px solid #ddd;
        }
        .factura-table thead th {
            border-bottom: 2px solid #ddd;
        }
        .btn-outline-dark {
            border-color: #ffd700;
            color: #ffd700;
            font-weight: bold;
            padding: 8px 20px;
            font-size: 14px;
        }
        .btn-outline-dark:hover {
            background-color: #ffd700;
            color: black;
        }
        .bg-dark {
            background-color: #343a40 !important;
        }
        h1, h3 {
            color: #343a40;
            font-weight: bold;
        }
        .container {
            max-width: 1200px;
        }
        .table-responsive {
            margin-top: 30px;
        }

        /* Diseño de una especie de marco de factura */
        .container {
            padding: 30px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .d-flex {
            margin-bottom: 30px;
        }
        .d-flex h1 {
            font-size: 32px;
            color: #333;
        }
    </style>

@endsection
