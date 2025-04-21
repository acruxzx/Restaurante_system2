@extends('layouts.app')

@section('template_title')
    Producto Pedidos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">{{ __('Producto Pedidos') }}</h5>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <!-- Formulario para filtrar por fecha -->
                                <form action="{{ route('producto-pedidos.index') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fecha de Inicio</span>
                                        </div>
                                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fecha de Fin</span>
                                        </div>
                                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                                    </div>
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-primary">Filtrar</button>
                                        <a class="btn btn-secondary btn-sm ml-2" href="{{ route('producto-pedidos.index') }}">Ver todo</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Fecha del pedido</th>
                                        <th>Pedido a nombre de:</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productoPedidos as $productoPedido)
                                        <tr class="shadow-sm">
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $productoPedido->created_at->format('d-m-Y') }}</td>
                                            <td>{{ $productoPedido->pedido->cliente->nombre }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-sm btn-info" href="{{ route('producto-pedidos.show', $productoPedido->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    {{--     <a class="btn btn-sm btn-success" href="{{ route('producto-pedidos.edit', $productoPedido->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> {{ __('Actualizar') }}
                                                    </a> --}}
                                                
                                                    <form action="{{ route('producto-pedidos.destroy', $productoPedido->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirm('¿Está seguro de eliminar este pedido?') ? this.closest('form').submit() : false;">
                                                            <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $productoPedidos->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
