<div class="row padding-1 p-1">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="medio_pago" class="form-label" style="color: #000;">
                {{ __('Medio Pago') }}
            </label>
            <input type="text" 
                   name="medio_pago" 
                   class="form-control @error('medio_pago') is-invalid @enderror" 
                   value="{{ old('medio_pago', $medioPago?->medio_pago) }}" 
                   id="medio_pago" 
                   placeholder="Medio Pago" 
                   style="border: 1px solid #d4af37; color: #000;">
            {!! $errors->first('medio_pago', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    
    <div class="col-md-12 mt-3">
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary me-2" 
                    style="background-color: #d4af37; border-color: #d4af37; color: #fff;">
                {{ __('Añadir') }}
            </button>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary" 
               style="color: #000; border-color: #d4af37;">
                {{ __('Cancelar') }}
            </a>
        </div>
    </div>
</div>
