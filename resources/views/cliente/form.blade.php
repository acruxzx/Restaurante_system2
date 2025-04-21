<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $cliente?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="telefono" class="form-label">{{ __('Telefono') }}</label>
            <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $cliente?->telefono) }}" id="telefono" placeholder="Telefono">
            {!! $errors->first('telefono', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="barrio" class="form-label">{{ __('Barrio') }}</label>
            <input type="text" name="barrio" class="form-control @error('barrio') is-invalid @enderror" value="{{ old('barrio', $cliente?->barrio) }}" id="barrio" placeholder="Barrio">
            {!! $errors->first('barrio', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="direccion" class="form-label">{{ __('Direccion') }}</label>
            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion', $cliente?->direccion) }}" id="direccion" placeholder="Direccion">
            {!! $errors->first('direccion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="notas" class="form-label">{{ __('Notas') }}</label>
            <input type="text" name="notas" class="form-control @error('notas') is-invalid @enderror" value="{{ old('notas', $cliente?->notas) }}" id="notas" placeholder="Notas">
            {!! $errors->first('notas', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" 
        class="btn btn-primary" 
        style="background-color: #000000; 
               border: 2px solid #FFD700; 
               color: #FFD700; 
               font-weight: bold; 
               padding: 10px 20px; 
               border-radius: 5px; 
               text-transform: uppercase; 
               transition: all 0.3s ease;">
    {{ __('Añadir') }}
</button>
<a href="{{ route('pedidos.create') }}" 
   class="btn btn-secondary" 
   style="background-color: #000000; 
          border: 2px solid #FFD700; 
          color: #FFD700; 
          font-weight: bold; 
          padding: 10px 20px; 
          border-radius: 5px; 
          text-transform: uppercase; 
          text-decoration: none; 
          transition: all 0.3s ease;">
    {{ __('Cancelar') }}
</a>


    </div>
</div>