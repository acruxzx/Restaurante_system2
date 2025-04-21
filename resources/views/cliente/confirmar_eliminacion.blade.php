@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg" style="background-color: #000000; border-radius: 15px;">
        <div class="card-header text-white" style="background-color: #000000; border-bottom: 2px solid #FFD700;">
            <h3 class="card-title font-weight-bold" style="font-family: 'Arial', sans-serif;">
                Confirmar Eliminación de Cliente
            </h3>
        </div>

        <div class="card-body text-white">
            <div class="mb-4">
                <h4><strong>Cliente:</strong> {{ $cliente->nombre }}</h4>
                <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                <p><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
                <p><strong>Notas:</strong> {{ $cliente->notas }}</p>
            </div>

            <div class="mb-4">
                <h5 style="color: #FFD700;"><strong>Pedidos Asociados:</strong> {{ $pedidos->count() }}</h5>

                @if ($pedidos->count() > 0)
                    <table class="table table-striped text-white">
                        <thead class="thead-dark" style="background-color: #34495e;">
                            <tr>
                                <th>ID Pedido</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->id }}</td>
                                    <td>{{ $pedido->pedido }}</td>
                                    <td>
                                        <span class="badge" 
                                              style="background-color: {{ $pedido->estadoPedido->estado == 'completado' ? '#FFD700' : '#e67e22' }}; color: black;">
                                            {{ $pedido->estadoPedido->estado }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No hay pedidos asociados a este cliente.</p>
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?')">
                        Eliminar Cliente
                    </button>
                </form>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
            </div>
        </div>
    </div>
</div>
@endsection
