<div class="row justify-content-center padding-1 p-1" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-3" style="background-color: #ffffff;">
            <div class="card-header text-center" style="background-color: #000; color: #d4af37;">
                <h5 class="mb-0">{{ __('Actualizar Producto') }}</h5>
            </div>
            <div class="card-body" style="background-color: #ffffff;">
                <div class="form-group mb-3">
                    <label for="nombre" class="form-label" style="color: #000;">{{ __('Nombre') }}</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre', $producto?->nombre) }}" id="nombre" placeholder="Nombre" required 
                           style="border: 1px solid #d4af37; color: #000;">
                    {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion" class="form-label" style="color: #000;">{{ __('Descripción') }}</label>
                    <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                           value="{{ old('descripcion', $producto?->descripcion) }}" id="descripcion" placeholder="Descripción" required 
                           style="border: 1px solid #d4af37; color: #000;">
                    {!! $errors->first('descripcion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                </div>
                <div class="form-group mb-3">
                    <label for="id_tp_productos" class="form-label" style="color: #000;">{{ __('Tipo de Producto') }}</label>
                    <select class="form-select @error('id_tp_productos') is-invalid @enderror" 
                            name="id_tp_productos" id="id_tp_productos" aria-label="Seleccione el tipo de producto" required 
                            style="border: 1px solid #d4af37; color: #000;">
                        <option value="" disabled {{ old('id_tp_productos', $producto?->id_tp_productos) ? '' : 'selected' }}>
                            {{ __('Seleccione el tipo de producto') }}
                        </option>
                        @foreach ($tp_producto as $tipo)
                            <option value="{{ $tipo->id }}" {{ (old('id_tp_productos', $producto?->id_tp_productos) == $tipo->id) ? 'selected' : '' }}>
                                {{ $tipo->tipo_producto }}
                            </option>
                        @endforeach
                    </select>
                    {!! $errors->first('id_tp_productos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                </div>
            </div>
            <div class="card-footer text-center" style="background-color: #f8f9fa;">
                <button type="button" id="btn-agregar-producto" class="btn btn-lg" 
                        style="background-color: #d4af37; color: #ffffff; border-color: #d4af37;">
                    {{ __('Actualizar Producto') }}
                </button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary" 
                   style="color: #000; border-color: #d4af37;">
                    {{ __('Cancelar') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btn-agregar-producto').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'PATCH',
                url: '{{ route("productos.update", $producto->id) }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'nombre': $('#nombre').val(),
                    'descripcion': $('#descripcion').val(),
                    'id_tp_productos': $('#id_tp_productos').val()
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.success,
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.href = data.redirect;
                        });
                    } else if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al procesar la solicitud. Intenta de nuevo más tarde.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        });
    });
</script>
