@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4 mt-5" style="font-weight: bold; color: #555;">Estadísticas de Ventas</h2>

    <!-- Filtros -->
    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
        <div class="row">
            <!-- Filtro de Mes -->
            <div class="col-md-4">
                <label for="mes" class="form-label">Mes</label>
                <select id="mes" name="mes" class="form-select">
                    <option value="">Todos</option>
                    @php
                        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                    @endphp
                    @foreach($meses as $index => $mes)
                        <option value="{{ $index + 1 }}" {{ request('mes') == $index + 1 ? 'selected' : '' }}>
                            {{ $mes }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro de Año -->
            <div class="col-md-4">
                <label for="anio" class="form-label">Año</label>
                <select id="anio" name="anio" class="form-select">
                    <option value="">Todos</option>
                    @for($year = 2024; $year <= now()->year; $year++)
                        <option value="{{ $year }}" {{ request('anio') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Botón de Filtrar -->
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Mensaje cuando no hay datos -->
    @if(empty($ventasPorMes))
        <div class="alert alert-info text-center" role="alert">
            No hay ventas registradas para el filtro seleccionado.
        </div>
    @else
        <!-- Gráficas -->
        <div class="row">
            <div class="col-md-8 mb-4">
                <!-- Gráfico de Barras de Ventas Mensuales -->
                <div class="card shadow-sm p-4">
                    <h5 class="text-center mb-3">Ventas por Mes</h5>
                    <canvas id="ventasChart" width="400" height="200"></canvas>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <!-- Gráfico de Pastel del Mes con Más Ventas -->
                <div class="card shadow-sm p-4">
                    <h5 class="text-center mb-3">Distribución de Ventas</h5>
                    <canvas id="ventasPieChart"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Gráfico de Línea de Ventas en el Tiempo -->
                <div class="card shadow-sm p-4">
                    <h5 class="text-center mb-3">Tendencia de Ventas</h5>
                    <canvas id="ventasLineChart"></canvas>
                </div>
            </div>
        </div>
    @endif
</div>
@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $ventasPorMesFormatted = collect($ventasPorMes)->mapWithKeys(function ($value, $key) use ($meses) {
        return [$meses[$key - 1] => $value];
    });
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
    const ventasPorMes = @json($ventasPorMesFormatted->values());
    const meses = @json($ventasPorMesFormatted->keys());
</script>

<script>
    const mesMaxVentas = @json($mesMaxVentas);

    // Gráfico de Barras
    const ctxBar = document.getElementById('ventasChart').getContext('2d');
    const ventasChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: meses,
            datasets: [{
                label: 'Ventas por Mes',
                data: ventasPorMes,
                backgroundColor: meses.map((_, index) => index + 1 === mesMaxVentas ? 'rgba(255, 99, 132, 0.6)' : 'rgba(54, 162, 235, 0.6)'),
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: { label: context => `Ventas: ${context.raw}` }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { color: '#333' } },
                x: { ticks: { color: '#333' } }
            }
        }
    });

    // Gráfico de Pastel
    const ctxPie = document.getElementById('ventasPieChart').getContext('2d');
    const ventasPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: meses,
            datasets: [{
                label: 'Distribución de Ventas',
                data: ventasPorMes,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { color: '#333' } } }
        }
    });

    // Gráfico de Línea
    const ctxLine = document.getElementById('ventasLineChart').getContext('2d');
    const ventasLineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{
                label: 'Tendencia de Ventas',
                data: ventasPorMes,
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { color: '#333' } },
                x: { ticks: { color: '#333' } }
            }
        }
    });
</script>
@endsection
