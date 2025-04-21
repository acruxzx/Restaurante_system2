@extends('layouts.app')

@section('template_title')
    {{ __('Gestión de Trabajadores') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-lg border-0 rounded">
                    <div class="card-header bg-dark text-white">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title" class="fs-4 fw-bold">
                                {{ __('Gestión de Trabajadores') }}
                            </span>
                            <div class="float-right">
                                <!-- Mejorar el botón "Crear Nuevo" para que se vea más visible -->
                                <a href="{{ route('trabajadores.create') }}" class="btn btn-warning btn-sm float-right">
                                  {{ __('Crear Nuevo') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-light">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">{{ __('No') }}</th>
                                        <th class="text-center">{{ __('Cédula') }}</th>
                                        <th class="text-center">{{ __('Nombre') }}</th>
                                        <th class="text-center">{{ __('Apellido') }}</th>
                                        <th class="text-center">{{ __('Teléfono') }}</th>
                                        <th class="text-center">{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trabajadores as $trabajadore)
                                        <tr>
                                            <td class="text-center">{{ ++$i }}</td>
                                            <td class="text-center">{{ $trabajadore->cedula }}</td>
                                            <td class="text-center">{{ $trabajadore->nombre }}</td>
                                            <td class="text-center">{{ $trabajadore->apellido }}</td>
                                            <td class="text-center">{{ $trabajadore->telefono }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('trabajadores.destroy', $trabajadore->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('trabajadores.show', $trabajadore->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-warning" href="{{ route('trabajadores.edit', $trabajadore->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirm('¿Está seguro de eliminar este trabajador?') ? this.closest('form').submit() : false;">
                                                        <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $trabajadores->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-warning {
            background-color: #f39c12; /* Color dorado más brillante */
            color: white;
        }
        .btn-warning:hover {
            background-color: #e67e22; /* Color dorado al pasar el ratón */
        }
        .card-header {
            background-color: #222;
            color: white;
        }
        .thead-dark th {
            background-color: #333;
            color: white;
        }
        .card-body {
            background-color: #f8f9fa;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
        }
        .alert-success {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }
    </style>
@endpush
