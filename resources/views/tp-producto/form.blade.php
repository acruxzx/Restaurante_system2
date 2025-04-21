<div class="form-group mb-3">
    <label for="tipo_producto" class="form-label" style="color: #000;">
        {{ __('Tipo Producto') }}
    </label>
    <input type="text" 
           name="tipo_producto" 
           class="form-control @error('tipo_producto') is-invalid @enderror" 
           value="{{ old('tipo_producto', $tpProducto?->tipo_producto) }}" 
           id="tipo_producto" 
           placeholder="Tipo Producto" 
           style="border: 1px solid #d4af37; color: #000;">
    {!! $errors->first('tipo_producto', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

<div class="d-flex justify-content-center mt-3">
    <button type="submit" class="btn btn-primary me-2" 
            style="background-color: #d4af37; border-color: #d4af37; color: #fff;">
        {{ __('Agregar') }}
    </button>
    <a href="{{ route('precios.create') }}" class="btn btn-secondary" 
       style="color: #000; border-color: #d4af37;">
        {{ __('Cancelar') }}
    </a>
</div>
