<div class="row justify-content-center padding-1 p-1">
    <div class="col-md-8">
        <div class="card border-light shadow-sm mb-3">
            <div class="card-header" style="background-color: #000000; color: #FFD700;">
                <h5 class="mb-0">{{ __('Agregar Producto y Precio') }}</h5>
            </div>

            <div class="card-body" style="background-color: #f0f0f0;">
                <form action="{{ route('productos.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
                        <input type="text" name="nombre_producto" class="form-control @error('nombre_producto') is-invalid @enderror" 
                               value="{{ old('nombre_producto') }}" id="nombre" placeholder="Nombre" required>
                        @error('nombre_producto')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="descripcion" class="form-label">{{ __('Descripción') }}</label>
                        <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                               value="{{ old('descripcion') }}" id="descripcion" placeholder="Descripción" required>
                        @error('descripcion')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <!-- Modificación en el select para Tipo de Producto -->
                    <div class="form-group mb-3">
                        <label for="id_tp_productos" class="form-label">{{ __('Tipo de Producto') }}</label>
                        <select class="form-select select2 @error('id_tp_productos') is-invalid @enderror" 
                                name="id_tp_productos" id="id_tp_productos" required>
                            <option value="" disabled selected>{{ __('Seleccione el tipo de producto') }}</option>
                            @foreach ($tp_productos as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('id_tp_productos') == $tipo->id ? 'selected' : '' }}>{{ $tipo->tipo_producto }}</option>
                            @endforeach
                        </select>
                        @error('id_tp_productos')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <div class="mt-2 text-center">
                            <a href="{{ route('tp-productos.create') }}" class="text-decoration-none" style="font-size: 0.85rem; color: #FFD700;">
                                {{ __('¿No encuentras el tipo de producto? Crear nuevo tipo') }}
                            </a>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_tamaño" class="form-label">{{ __('Tamaño') }}</label>
                        <select class="form-select select2 @error('id_tamaño') is-invalid @enderror" 
                                name="id_tamaño" id="id_tamaño" required>
                            <option value="" disabled selected>{{ __('Seleccione el tamaño') }}</option>
                            @foreach ($tamaños as $tamaño)
                                <option value="{{ $tamaño->id }}" {{ old('id_tamaño') == $tamaño->id ? 'selected' : '' }}>{{ $tamaño->nombre }}</option>
                            @endforeach
                        </select>
                        @error('id_tamaño')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <div class="mt-2 text-center">
                            <a href="{{ route('tamanos.create') }}" class="text-decoration-none" style="font-size: 0.85rem; color: #FFD700;">
                                {{ __('¿No encuentras el tamaño? Crear nuevo tamaño') }}
                            </a>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="precio" class="form-label">{{ __('Precio') }}</label>
                        <input type="text" name="precio" class="form-control @error('precio') is-invalid @enderror" 
                               value="{{ old('precio') }}" id="precio" placeholder="Precio" required>
                        @error('precio')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-warning btn-lg">{{ __('Agregar Producto y Precio') }}</button>
                        <a href="{{ route('precios.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Agregar estilos -->
<style>
    .form-label {
        color: #000000;
    }
    .btn-warning {
        background-color: #FFD700;
        border: none;
    }
</style>

<!-- Incluir Select2 para búsqueda interactiva -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Hacer ambos select2 interactivos
        $('.select2').select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });
    });
</script>
