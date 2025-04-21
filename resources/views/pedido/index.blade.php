@extends('layouts.app')

@section('template_title')
    Pedidos
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-lg border-0">
                <!-- Cabecera -->
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-truck-loading"></i> {{ __('Gestión de Pedidos') }}
                    </h5>
                    <a href="{{ route('pedidos.create') }}" class="btn btn-outline-gold">
                        <i class="fas fa-plus"></i> {{ __('Nuevo Pedido') }}
                    </a>
                </div>
                
                <!-- Mensaje de éxito -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success m-3">
                        <i class="fas fa-check-circle"></i> {{ $message }}
                    </div>
                @endif

               <!-- Filtros -->
            <div class="card-body bg-dark text-white rounded shadow-lg">
                <form action="{{ route('pedidos.index') }}" method="GET" class="row g-3 align-items-end">
                    <!-- Filtro Número de Pedido -->
                    <div class="col-md-4">
                        <label for="id" class="form-label text-gold">Número de Pedido</label>
                        <input type="text" name="id" id="id" class="form-control bg-dark border-gold text-white" value="{{ request('id') }}" placeholder="Ej: 1234">
                    </div>

                    <!-- Filtro Estado -->
                    <div class="col-md-4">
                        <label for="estado" class="form-label text-gold">Estado</label>
                        <select name="estado" id="estado" class="form-select bg-dark border-gold text-white">
                            <option value="">Todos</option>
                            <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Completado" {{ request('estado') == 'Completado' ? 'selected' : '' }}>Completado</option>
                            <option value="Cancelado" {{ request('estado') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>

                    <!-- Filtro Trabajador -->
                    <div class="col-md-4">
                        <label for="trabajador" class="form-label text-gold">Trabajador</label>
                        <select name="trabajador" id="trabajador" class="form-select bg-dark border-gold text-white">
                            <option value="">Todos</option>
                            @foreach ($trabajadores as $trabajador)
                                <option value="{{ $trabajador->id }}" {{ request('trabajador') == $trabajador->id ? 'selected' : '' }}>
                                    {{ $trabajador->nombre }} {{ $trabajador->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                      <!-- Filtro Trabajador -->
                      <div class="col-md-4">
                        <label for="tipo" class="form-label text-gold">Tipo de pedidos</label>
                        <select name="tipo" id="tipo" class="form-select bg-dark border-gold text-white">
                            <option value="">Todos</option>
                            @foreach ($tipo as $tipo)
                                <option value="{{ $tipo->id }}" {{ request('tipo de pedido') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->tp_pedido }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Botones -->
                    <div class="col-md-4 d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-outline-gold w-100">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-redo"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>


                <!-- Tabla de resultados -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tablaPedidos" >
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>#Pedido</th>
                                    <th>Fecha</th>
                                    <th>Trabajador</th>
                                    <th>Cliente</th>
                                    <th>Estado</th>
                                    <th>Tipo</th>
                                    <th>Valor total</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pedidos as $pedido)
                                    <tr>
                                        <td>{{ $pedido->id }}</td>
                                        <td>{{ $pedido->created_at }}</td>
                                        @if ($pedido->userTrabajador)
                                        <td>{{ $pedido->userTrabajador->nombre }} {{ $pedido->userTrabajador->apellido }}</td>
                                    @else
                                        <span class="text-danger">Trabajador no reconocido</span>
                                    @endif
                                        <td>{{ $pedido->cliente->nombre }}</td>
                                        <td>
                                            <span class="badge 
                                                @switch($pedido->estadoPedido->estado)
                                                    @case('Pendiente') bg-warning text-dark @break
                                                    @case('Completado') bg-info text-dark @break
                                                    @case('Cancelado') bg-danger @break
                                                    @default bg-secondary
                                                @endswitch">
                                                {{ $pedido->estadoPedido->estado }}
                                            </span>
                                        </td>
                                        <td>{{ $pedido->tpPedido->tp_pedido }}</td>
                                        <td>${{ number_format($pedido->total_factura, 2) }}</td> <!-- Muestra el total con formato -->
                                        @auth
                                        @php
                                            $rol = Auth::check() ? Auth::user()->id_rol : null;
                                        @endphp
                                    
                                        <!-- Botones de acción solo visibles para el rol adecuado -->
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-outline-info btn-sm" title="Ver Pedido">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                    
                                                <!-- Acciones solo para el rol de Administrador (id_rol == 1) o cualquier otro rol con permisos de edición -->
                                                @if ($rol == 1) <!-- Administrador -->
                                                    @if ($pedido->estadoPedido->estado === 'Pendiente')
                                                        <a href="{{ route('producto-pedidos.create', ['pedido' => $pedido->id]) }}" class="btn btn-outline-info btn-sm" title="Asignar producto">
                                                            <i class="fas fa-box"></i>
                                                        </a>
                                                        <a href="{{ route('ventas.create', $pedido->id) }}" class="btn btn-outline-success btn-sm" title="Completar Pedido">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-outline-primary btn-sm" title="Editar">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    @endif
                                    
                                                    @if ($pedido->estadoPedido->estado === 'Completado')
                                                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-outline-primary btn-sm" title="Actualizar">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    @endif
                                    
                                                    @if ($pedido->estadoPedido->estado === 'Cancelado')
                                                        <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este pedido?')">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @elseif ($rol == 2 ) <!-- Cajero: solo puede ver y realizar otras acciones, no editar ni eliminar -->
                                                    @if ($pedido->estadoPedido->estado === 'Pendiente')
                                                        <a href="{{ route('producto-pedidos.create', ['pedido' => $pedido->id]) }}" class="btn btn-outline-info btn-sm" title="Asignar producto">
                                                            <i class="fas fa-box"></i>
                                                        </a>
                                                        <a href="{{ route('ventas.create', $pedido->id) }}" class="btn btn-outline-success btn-sm" title="Completar Pedido">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    @endif
                                                    @elseif ($rol == 3 ) <!-- Cajero: solo puede ver y realizar otras acciones, no editar ni eliminar -->
                                                    @if ($pedido->estadoPedido->estado === 'Pendiente')
                                                        <a href="{{ route('producto-pedidos.create', ['pedido' => $pedido->id]) }}" class="btn btn-outline-info btn-sm" title="Asignar producto">
                                                            <i class="fas fa-box"></i>
                                                        </a>
                                                        <a href="{{ route('ventas.create', $pedido->id) }}" class="btn btn-outline-success btn-sm" title="Completar Pedido">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    @endif
                                                    @elseif ($rol == 4 ) <!-- Cajero: solo puede ver y realizar otras acciones, no editar ni eliminar -->
                                                    @if ($pedido->estadoPedido->estado === 'Pendiente')
                                                        <a href="{{ route('producto-pedidos.create', ['pedido' => $pedido->id]) }}" class="btn btn-outline-info btn-sm" title="Asignar producto">
                                                            <i class="fas fa-box"></i>
                                                        </a>
                                                        <a href="{{ route('ventas.create', $pedido->id) }}" class="btn btn-outline-success btn-sm" title="Completar Pedido">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    @endif
                                            
                                                @endif
                                            </div>
                                        </td>
                                    @endauth                                    
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No se encontraron resultados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {!! $pedidos->appends(request()->query())->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Botón innovador */
    .btn-outline-gold {
        color: #d4af37;
        border: 2px solid #d4af37;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-outline-gold:hover {
        background-color: #d4af37;
        color: #1c1c1c;
        box-shadow: 0 0 15px #d4af37;
    }

    .table-hover tbody tr:hover {
        background-color: #333333;
    }

    .bg-dark {
        background-color: #1c1c1c !important;
    }

    .border-gold {
        border: 2px solid #d4af37 !important;
    }

    .text-gold {
        color: #d4af37;
    }

    .form-control, .form-select {
        border-radius: 5px;
        transition: border 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #d4af37;
        box-shadow: 0 0 5px #d4af37;
    }
</style>
<script>
    // Refresca la página cada 30 segundos (30000 milisegundos)
    setInterval(function(){
        location.reload();
    }, 30000);
</script>


<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK'
    });
</script>
@endif
@endsection
