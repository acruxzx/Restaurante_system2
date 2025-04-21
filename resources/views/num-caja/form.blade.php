<div class="row justify-content-center padding-1 p-1">
    <div class="col-md-8">
        <div class="card border-light shadow-sm mb-3">
            <div class="card-header" style="background-color: #000000; color: #FFD700;">
                <h5 class="mb-0">{{ __('Número de Caja') }}</h5>
            </div>

            <div class="card-body" style="background-color: #f0f0f0;">
                <form action="{{ route('num-cajas.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="caja" class="form-label">{{ __('Caja') }}</label>
                        <input type="text" name="caja" class="form-control @error('caja') is-invalid @enderror" 
                               value="{{ old('caja', $numCaja?->caja) }}" 
                               id="caja" placeholder="Caja" required>
                        {!! $errors->first('caja', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                    </div>

                    <div class="form-group mb-3">
                        <label for="base_dia" class="form-label">{{ __('Base Día') }}</label>
                        <input type="text" name="base_dia" class="form-control @error('base_dia') is-invalid @enderror" 
                               value="{{ old('base_dia', $numCaja?->base_dia) }}" 
                               id="base_dia" placeholder="Base para el turno Día" required>
                        {!! $errors->first('base_dia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                    </div>

                    <div class="form-group mb-3">
                        <label for="base_noche" class="form-label">{{ __('Base Noche') }}</label>
                        <input type="text" name="base_noche" class="form-control @error('base_noche') is-invalid @enderror" 
                               value="{{ old('base_noche', $numCaja?->base_noche) }}" 
                               id="base_noche" placeholder="Base para el turno Noche" required>
                        {!! $errors->first('base_noche', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-warning btn-lg">{{ __('Guardar Caja') }}</button>
                        <a href="{{ route('num-cajas.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Estilos personalizados -->
<style>
    .form-label {
        color: #000000;
    }
    .btn-warning {
        background-color: #FFD700;
        border: none;
    }
    .btn-secondary {
        color: #FFFFFF;
        background-color: #333333;
        border: none;
    }
    .btn-secondary:hover {
        background-color: #555555;
    }
</style>
