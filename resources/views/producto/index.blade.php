@extends('layouts.app')

@section('template_title')
    Productos
@endsection

@section('content')
    <div class="container-fluid mt-5"> <!-- Add margin top for separation -->
        <div class="row justify-content-center"> <!-- Center the row -->
            <div class="col-sm-12">
                <div class="card shadow-lg" style="border: 1px solid #D4AF37;">
                    <div class="card-header" style="background-color: #121212; color: #D4AF37;">
                        <h5 class="mb-0">{{ __('Gestión de Productos') }}</h5>
                    </div>
                    <div class="card-body" style="background-color: #f8f9fa; color: black;">
                        <div class="row mb-3">
                            <div class="col-md-6"> <!-- Removed offset to allow centering through the row -->
                                <form action="{{ route('productos.index') }}" method="get" class="d-flex justify-content-center"> <!-- Center form elements -->
                                    <input type="text" name="busqueda" class="form-control me-2" placeholder="Buscar producto" aria-label="Buscar producto">
                                    <button type="submit" class="btn" style="background-color: #D4AF37; color: black;">{{ __('Buscar') }}</button>
                                    <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-sm ms-2">Mostrar Todo</a>
                                </form>
                            </div>
                        </div>

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success m-4">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead style="background-color: #D4AF37; color: black;">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Tipo de Producto</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td class="text-center">{{ ++$i }}</td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>{{ $producto->descripcion }}</td>
                                            <td>{{ $producto->tpProducto->tipo_producto }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                                    <a class="btn btn-sm" style="background-color: #D4AF37; color: black;" href="{{ route('productos.show', $producto->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm" style="background-color: #D4AF37; color: black;" href="{{ route('productos.edit', $producto->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirm('¿Está seguro de eliminar?') ? this.closest('form').submit() : false;">
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
                    <div class="card-footer" style="background-color: #f8f9fa; border-top: 1px solid #D4AF37;">
                        {!! $productos->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #e9ecef; /* Fondo claro para filas alternas */
        }

        .table-striped tbody tr:hover {
            background-color: #D4AF37; /* Color de fondo en hover dorado */
            color: black; /* Color de texto en hover negro */
        }

        .alert-success {
            background-color: #D4AF37; /* Color de fondo de alerta */
            color: black; /* Color de texto de alerta */
        }
    </style>
@endsection
