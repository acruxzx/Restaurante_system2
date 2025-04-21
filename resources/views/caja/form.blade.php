<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="egreso" class="form-label">{{ __('Egreso') }}</label>
            <input type="text" name="egreso" class="form-control @error('egreso') is-invalid @enderror" value="{{ old('egreso', $caja?->egreso) }}" id="egreso" placeholder="Egreso">
            {!! $errors->first('egreso', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="inicio" class="form-label">{{ __('Inicio') }}</label>
            <input type="text" name="inicio" class="form-control @error('inicio') is-invalid @enderror" value="{{ old('inicio', $caja?->inicio) }}" id="inicio" placeholder="Inicio">
            {!! $errors->first('inicio', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fin" class="form-label">{{ __('Fin') }}</label>
            <input type="text" name="fin" class="form-control @error('fin') is-invalid @enderror" value="{{ old('fin', $caja?->fin) }}" id="fin" placeholder="Fin">
            {!! $errors->first('fin', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_trabajador" class="form-label">{{ __('Id Trabajador') }}</label>
            <input type="text" name="id_trabajador" class="form-control @error('id_trabajador') is-invalid @enderror" value="{{ old('id_trabajador', $caja?->id_trabajador) }}" id="id_trabajador" placeholder="Id Trabajador">
            {!! $errors->first('id_trabajador', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_num_caja" class="form-label">{{ __('Id Num Caja') }}</label>
            <input type="text" name="id_num_caja" class="form-control @error('id_num_caja') is-invalid @enderror" value="{{ old('id_num_caja', $caja?->id_num_caja) }}" id="id_num_caja" placeholder="Id Num Caja">
            {!! $errors->first('id_num_caja', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>