@extends('layouts.app')

@section('template_title')
    {{ __('Gestión de Cajas') }}
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-light shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-dark text-warning">
                        <h5 class="mb-0">{{ __('Lista de Cajas') }}</h5>
                        <a href="{{ route('num-cajas.create') }}" class="btn btn-warning btn-sm text-dark">
                            <i class="fa fa-plus"></i> {{ __('Agregar Nueva Caja') }}
                        </a>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <!-- Filtro de estado -->
                    <form method="GET" action="{{ route('num-cajas.index') }}" class="mb-3">
                        <div class="form-group">
                            <label for="estado" class="text-dark">{{ __('Filtrar por estado') }}</label>
                            <select name="estado" id="estado" class="form-control" onchange="this.form.submit()">
                                <option value="activa" {{ $estado == 'activa' ? 'selected' : '' }}>{{ __('Activa') }}</option>
                                <option value="inactiva" {{ $estado == 'inactiva' ? 'selected' : '' }}>{{ __('Inactiva') }}</option>
                            </select>
                        </div>
                    </form>

                    <div class="card-body bg-light">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="bg-warning text-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>{{ __('Caja') }}</th>
                                        <th>{{ __('Base dia') }}</th>
                                        <th>{{ __('Base noche') }}</th>
                                        <th>{{ __('Estado') }}</th>
                                        <th class="text-center">{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($numCajas as $numCaja)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $numCaja->caja }}</td>
                                            <td>{{ number_format($numCaja->base_dia, 2) }}</td>
                                            <td>{{ number_format($numCaja->base_noche, 2) }}</td>
                                            <td>{{ $numCaja->estado }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('num-cajas.destroy', $numCaja->id) }}" method="POST" class="d-inline">
                                                    <a href="{{ route('num-cajas.show', $numCaja->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a href="{{ route('num-cajas.edit', $numCaja->id) }}" class="btn btn-sm btn-success">
                                                        <i class="fa fa-edit"></i> {{ __('Actualizar') }}
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('¿Estás seguro de desactivar esta caja?') }}')">
                                                        <i class="fa fa-trash"></i> {{ __('Eliminar') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {!! $numCajas->withQueryString()->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-warning {
            background-color: #FFD700;
            border: none;
        }

        .btn-warning:hover {
            background-color: #FFC107;
        }

        .card-header {
            font-weight: bold;
        }

        .table-hover tbody tr:hover {
            background-color: #f7f7f7;
        }

        .bg-warning {
            background-color: #FFD700 !important;
        }
    </style>
@endsection
