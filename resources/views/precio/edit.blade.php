@extends('layouts.app')

@section('template_title')
    {{ __('Actualizar Producto y Precio') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="background-color: #1a1a1a; border: 2px solid #d4af37;">
                    <div class="card-header" style="background-color: #000000; color: #FFD700;">
                        <span class="card-title">{{ __('Actualizar Producto y Precio') }}</span>
                    </div>
                    <div class="card-body" style="background-color: #f0f0f0;">
                        <form method="POST" action="{{ route('precios.update', $precio->id) }}" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            <!-- Campos de Producto -->
                            <h5 class="text-dark mb-3">Información del Producto</h5>
                            <div class="form-group mb-3">
                                <label for="nombre" style="color: #d4af37;">Nombre del Producto</label>
                                <input type="text" name="nombre" id="nombre" 
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $precio->producto->nombre) }}" required 
                                       style="background-color: #f8f3f3; border: 1px solid #d4af37; color: #050505;">
                                @error('nombre')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="descripcion" style="color: #d4af37;">Descripción</label>
                                <input type="text" name="descripcion" id="descripcion" 
                                       class="form-control @error('descripcion') is-invalid @enderror"
                                       value="{{ old('descripcion', $precio->producto->descripcion) }}" required 
                                       style="background-color: #f8f3f3; border: 1px solid #d4af37; color: #050505;">
                                @error('descripcion')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="id_tamaños" style="color: #d4af37;">Tamaño</label>
                                <select class="form-select @error('id_tamaños') is-invalid @enderror" 
                                        name="id_tamaños" id="id_tamaños" required 
                                        style="background-color: #f8f3f3; border: 1px solid #d4af37; color: #050505;">
                                    @foreach ($tamaños as $tamaño)
                                        <option value="{{ $tamaño->id }}" 
                                            {{ old('id_tamaños', $precio->id_tamaños) == $tamaño->id ? 'selected' : '' }}>
                                            {{ $tamaño->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_tamaños')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            

                            <div class="form-group mb-3">
                                <label for="id_tp_productos" style="color: #d4af37;">Tipo de Producto</label>
                                <select class="form-select @error('id_tp_productos') is-invalid @enderror" 
                                        name="id_tp_productos" id="id_tp_productos" required 
                                        style="background-color: #f8f3f3; border: 1px solid #d4af37; color: #050505;">
                                    @foreach ($tp_producto as $tipo)
                                        <option value="{{ $tipo->id }}" 
                                            {{ old('id_tp_productos', $precio->producto->id_tp_productos) == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->tipo_producto }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_tp_productos')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Campos de Precio -->
                            <h5 class="text-dark mb-3">Información del Precio</h5>
                            <div class="form-group mb-3">
                                <label for="precio" style="color: #d4af37;">Precio</label>
                                <input type="text" name="precio" class="form-control @error('precio') is-invalid @enderror" 
                                       id="precio" value="{{ old('precio', $precio->precio) }}" required 
                                       style="background-color: #faf6f6; border: 1px solid #d4af37; color: #060606;">
                                @error('precio')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Botones de acción -->
                            <div class="form-group mb-4">
                                <button type="submit" class="btn btn-primary" 
                                        style="background-color: #d4af37; border: 1px solid #d4af37; color: #222; font-weight: bold;">
                                    {{ __('Actualizar') }}
                                </button>
                                <a href="{{ route('precios.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
@endsection
