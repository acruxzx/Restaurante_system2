@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Cierre de Caja</h2>

    <form id="cierreForm" method="POST" action="{{ route('cierres_caja.cerrar') }}">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="id_caja">Caja:</label>
                <select name="id_caja" id="id_caja" class="form-select" required>
                    @foreach ($cajas as $caja)
                        <option value="{{ $caja->id }}">{{ $caja->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="turno">Turno:</label>
                <select name="turno" id="turno" class="form-select" required>
                    <option value="dia">Día</option>
                    <option value="noche">Noche</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="monto_inicial">Monto Inicial:</label>
                <input type="number" name="monto_inicial" id="monto_inicial" class="form-control" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label for="total_ventas">Total Ventas:</label>
                <input type="number" name="total_ventas" id="total_ventas" class="form-control" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label for="monto_final">Monto Final:</label>
                <input type="number" name="monto_final" id="monto_final" class="form-control" readonly>
            </div>
        </div>

        <button type="button" id="calcularButton" class="btn btn-primary">Calcular</button>
        <button type="submit" class="btn btn-success">Cerrar Turno</button>
    </form>
</div>

<script>
    document.getElementById('calcularButton').addEventListener('click', function () {
        const idCaja = document.getElementById('id_caja').value;
        const turno = document.getElementById('turno').value;
        const fecha = document.getElementById('fecha').value;

        fetch('{{ route("cierres_caja.calcular") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id_caja: idCaja, turno: turno, fecha: fecha })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('monto_inicial').value = data.monto_inicial;
            document.getElementById('total_ventas').value = data.total_ventas;
            document.getElementById('monto_final').value = data.monto_final;
        });
    });
</script>
@endsection
