@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Pedido
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Pedido</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('pedidos.update', $pedido->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                         <!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        Swal.fire({
            title: 'Producto Agregado',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
    .form-container {
        background-color: #1a1a1a;
        color: #f8f8f6;
        padding: 20px;
        border-radius: 8px;
    }
    .form-container .form-label {
        color: #fcfbf8;
        font-weight: bold;
    }
    .form-container .form-control {
        background-color: #333;
        color: #f8f7f2;
        border: 1px solid #FFD700;
    }
    .form-container .form-control:focus {
        border-color: #ffa500;
        box-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
    }
    .form-container .btn-primary {
        background-color: #FFD700;
        border: none;
        color: #1a1a1a;
        font-weight: bold;
    }
    .form-container .btn-primary:hover {
        background-color: #e5b800;
        color: #1a1a1a;
    }
    .form-container .is-invalid {
        border-color: #FF4500;
        box-shadow: 0 0 5px rgba(255, 69, 0, 0.5);
    }
    .form-container .invalid-feedback {
        color: #FF4500;
    }
</style>

<div class="form-container">
    <div class="row p-1">
        <div class="col-md-12">
      <!-- Fecha y hora del pedido -->
<div class="form-group mb-2">
    <label for="pedido" class="form-label">{{ __('Pedido') }}</label>
    <input type="datetime-local" name="pedido" class="form-control @error('pedido') is-invalid @enderror" 
           id="pedido" value="{{ isset($pedido) && $pedido->exists ? $pedido->pedido : '' }}" readonly>
    {!! $errors->first('pedido', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pedidoInput = document.getElementById('pedido');
        @if (!isset($pedido) || !$pedido->exists)
            const now = new Date();
            const formattedDate = now.toISOString().slice(0, 16);
            pedidoInput.value = formattedDate;
        @endif
    });
</script>

<!-- Trabajador -->
<label for="trabajador" class="form-label">{{ __('Trabajador') }}</label>
<select name="id_trabajador" id="id_trabajador" class="form-control">
    @foreach ($trabajador as $item)
        <option value="{{ $item->id }}" 
            {{ isset($pedido) && $pedido->id_trabajador == $item->id ? 'selected' : '' }}>
            {{ $item->nombre }} - {{ $item->apellido }}
        </option>
    @endforeach
</select>

<!-- Cliente -->
<div class="form-group mb-2">
    <label for="buscar-cliente" class="form-label">{{ __('Cliente') }}</label>
    <div class="input-group">
        <input type="text" id="buscar-cliente" class="form-control" placeholder="Escribe para buscar un cliente..." 
               autocomplete="off" value="{{ isset($pedido) ? $pedido->cliente->nombre : '' }}" />
        <input type="hidden" name="id_cliente" id="id_cliente" value="{{ isset($pedido) ? $pedido->id_cliente : '' }}">
        <button type="button" id="btn-ver-cliente" class="btn btn-secondary" 
                {{ isset($pedido) ? '' : 'disabled' }}>Ver Información</button>
    </div>
    <small>
        <a href="{{ route('clientes.create', ['redirect_to' => 'pedido']) }}" class="text-decoration-none" 
           style="font-size: 0.85rem; color: #FFD700;">Agregar nuevo cliente</a>
    </small>
</div>

<!-- Estado del Pedido -->
<div class="form-group mb-2">
    <label for="id_estado_pedido" class="form-label">{{ __('Estado de pedido') }}</label>
    @if (isset($pedido) && $pedido->exists)
        <select name="id_estadoPedido" class="form-control @error('id_estadoPedido') is-invalid @enderror" 
                id="id_estado_pedido">
            @foreach ($estado as $est)
                <option value="{{ $est->id }}" 
                    {{ $pedido->id_estadoPedido == $est->id ? 'selected' : '' }}>
                    {{ $est->estado }}
                </option>
            @endforeach
        </select>
    @else
        <input type="hidden" name="id_estadoPedido" value="2">
        <input type="text" class="form-control" value="Pendiente" disabled>
    @endif
</div>

<!-- Tipo de Pedido -->
<div class="form-group mb-2">
    <label for="id_tp_pedido" class="form-label">{{ __('Tipo Pedido') }}</label>
    <select name="id_tp_pedido" class="form-control @error('id_tp_pedido') is-invalid @enderror" 
            id="id_tp_pedido">
        @foreach ($tp_pedido as $tp)
            <option value="{{ $tp->id }}" 
                {{ isset($pedido) && $pedido->id_tp_pedido == $tp->id ? 'selected' : '' }}>
                {{ $tp->tp_pedido }}
            </option>
        @endforeach
    </select>
</div>

            
            <!-- Botones -->
            <div class="col-md-12 mt-2">
                <button type="submit" class="btn btn-primary">{{ __('Agregar') }}</button>
                <a href="{{ route('pedidos.index') }}" class="btn btn-secondary" style="color: white;">{{ __('Volver') }}</a>
            </div>
        </div>
    </div>
</div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
