@extends('layouts.app')

@section('template_title')
    Tipo de Productos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-sm border-0 mb-4 mt-5">
                    <div class="card-header" style="background-color: #000000; color: #FFD700;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                {{ __('Tipo de Productos') }}
                            </h4>

                            <a href="{{ route('tp-productos.create') }}" class="btn btn-outline-warning btn-sm">
                                {{ __('Agregar nuevo') }}
                            </a>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p class="mb-0">{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-light">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-center">
                                <thead class="thead-dark" style="background-color: #FFD700; color: #000000;">
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th>Tipo Producto</th>
                                        <th style="width: 30%;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tpProductos as $tpProducto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $tpProducto->tipo_producto }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-sm btn-info mx-1" href="{{ route('tp-productos.show', $tpProducto->id) }}">
                                                        <i class="fa fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-warning mx-1" href="{{ route('tp-productos.edit', $tpProducto->id) }}">
                                                        <i class="fa fa-edit"></i> {{ __('Actualizar') }}
                                                    </a>
                                                    <form action="{{ route('tp-productos.destroy', $tpProducto->id) }}" method="POST" class="mx-1">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este elemento?')">
                                                            <i class="fa fa-trash"></i> {{ __('Eliminar') }}
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
                <div class="d-flex justify-content-center">
                    {!! $tpProductos->withQueryString()->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .card-header {
        background-color: #000000; /* Color de fondo de la cabecera */
        color: #FFD700; /* Color del texto */
    }
    .thead-dark {
        background-color: #FFD700; /* Color de fondo del encabezado de la tabla */
        color: #000000; /* Color del texto del encabezado */
    }
    .btn-outline-warning {
        color: #FFD700; /* Color del texto del botón */
        border-color: #FFD700; /* Color del borde del botón */
    }
    .btn-outline-warning:hover {
        background-color: #FFD700; /* Color de fondo al pasar el ratón */
        color: #000000; /* Color del texto al pasar el ratón */
    }
</style>
