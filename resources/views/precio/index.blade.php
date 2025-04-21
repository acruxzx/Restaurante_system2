@extends('layouts.app')

@section('template_title')
    Gestión de Productos y Precios
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-light shadow-sm">
                    <div class="card-header" style="background-color: #000000; color: #FFD700;">
                        <h5 class="mb-0">{{ __('Gestión de Productos y Precios') }}</h5>
                    </div>
                    @if (auth()->user()->id_rol == '1')
                    <div class="float-right">
                        <a href="{{ route('precios.create') }}" class="btn btn-light btn-sm float-right" data-placement="left">
                            <i class="fas fa-plus"></i> {{ __('Agregar un nuevo producto') }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Notificación de éxito -->
            @if (session('success'))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'Aceptar'
                    });
                });
            </script>
            @endif

            <div class="card-body" style="background-color: #f0f0f0;">
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-3">
                        <form action="{{ route('precios.index') }}" method="get" class="d-flex">
                            <!-- Campo de búsqueda -->
                            <input type="text" name="busqueda" class="form-control me-2" placeholder="Buscar producto" aria-label="Buscar producto" value="{{ request('busqueda') }}">
                            
                            <!-- Filtro por estado -->
                            <select name="estado" class="form-select me-2">
                                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                            </select>
                               <!-- Filtro por tipo de producto -->
                            <select name="tipo_producto" class="form-select me-2">
                                <option value="">Todos los tipos</option>
                                @foreach ($tiposProducto as $tipo)
                                    <option value="{{ $tipo->id }}" {{ request('tipo_producto') == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->tipo_producto }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <!-- Botones -->
                            <button type="submit" class="btn btn-warning">{{ __('Buscar') }}</button>
                            <a href="{{ route('precios.index') }}" class="btn btn-secondary btn-sm ms-2">Mostrar Todo</a>
                        </form>
                    </div>
                </div>

                <!-- Tabla de datos -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #000000; color: #FFD700;">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Tipo de Producto</th>
                                <th>Tamaño</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($precios as $precio)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td>{{ $precio->producto->nombre }}</td>
                                    <td>{{ $precio->producto->descripcion }}</td>
                                    <td>{{ $precio->producto->tpProducto->tipo_producto }}</td>
                                    <td>{{ $precio->tamanos->nombre }}</td>
                                    <td>{{ $precio->precio }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $precio->estado == 'activo' ? 'success' : 'danger' }}">
                                            {{ ucfirst($precio->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($precio->estado == 'activo')
                                            <!-- Botón de ver, accesible para todos -->
                                            <a class="btn btn-sm btn-warning" href="{{ route('precios.show', $precio->id) }}">
                                                <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                            </a>
                                    
                                            <!-- Condiciones para verificar si el usuario es administrador -->
                                            @if (auth()->user()->id_rol == '1')
                                                <!-- Botón de editar -->
                                                <a class="btn btn-sm btn-success" href="{{ route('precios.edit', $precio->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i> {{ __('Actualizar precio') }}
                                                </a>
                                    
                                                <!-- Botón de inactivar -->
                                                <form action="{{ route('precios.inactivar', $precio->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Inactivar" onclick="return confirm('¿Estás seguro de inactivar este producto?')">
                                                        <i class="far fa-trash-alt"></i> {{ __('Inactivar') }}
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @if (auth()->user()->id_rol == '1')
                                                <!-- Botón de activar -->
                                                <form action="{{ route('precios.activar', $precio->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm" title="Activar" onclick="return confirm('¿Estás seguro de activar este producto?')">
                                                        <i class="fas fa-check"></i> {{ __('Activar') }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            <div class="card-footer" style="background-color: #f8f9fa; border-top: 1px solid #FFD700;">
                {!! $precios->withQueryString()->links() !!}
            </div>
        </div>
    </div>

    <style>
        .table {
            font-size: 0.9rem;
        }

        .table th {
            background-color: #000000;
            color: #FFD700;
        }

        .table tbody tr:hover {
            background-color: #FFD700;
        }

        .card {
            border-radius: 10px;
        }
    </style>
@endsection
