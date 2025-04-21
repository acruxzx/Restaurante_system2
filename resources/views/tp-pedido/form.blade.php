<div class="form-group mb-3">
    <label for="tp_pedido" class="form-label" style="color: #000;">
        {{ __('Tp Pedido') }}
    </label>
    <input type="text" 
           name="tp_pedido" 
           class="form-control @error('tp_pedido') is-invalid @enderror" 
           value="{{ old('tp_pedido', $tpPedido?->tp_pedido) }}" 
           id="tp_pedido" 
           placeholder="Tipo Pedido" 
           style="border: 1px solid #d4af37; color: #000;">
    {!! $errors->first('tp_pedido', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
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
