<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title mb-0">Formulario de Trabajador</h4>
                </div>
                <div class="card-body bg-light">
                    <form method="POST" action="{{ route('trabajadores.store') }}">
                        @csrf

                        <div class="row padding-1 p-1">
                            <div class="col-md-12">
                                
                                <!-- Cedula -->
                                <div class="form-group mb-3">
                                    <label for="cedula" class="form-label text-muted">{{ __('Cedula') }}</label>
                                    <input type="text" name="cedula" class="form-control @error('cedula') is-invalid @enderror" 
                                           value="{{ old('cedula', $trabajadore?->cedula) }}" id="cedula" placeholder="Cedula">
                                    {!! $errors->first('cedula', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>

                                <!-- Nombre -->
                                <div class="form-group mb-3">
                                    <label for="nombre" class="form-label text-muted">{{ __('Nombre') }}</label>
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre', $trabajadore?->nombre) }}" id="nombre" placeholder="Nombre">
                                    {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>

                                <!-- Apellido -->
                                <div class="form-group mb-3">
                                    <label for="apellido" class="form-label text-muted">{{ __('Apellido') }}</label>
                                    <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror" 
                                           value="{{ old('apellido', $trabajadore?->apellido) }}" id="apellido" placeholder="Apellido">
                                    {!! $errors->first('apellido', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>

                                <!-- Teléfono -->
                                <div class="form-group mb-3">
                                    <label for="telefono" class="form-label text-muted">{{ __('Teléfono') }}</label>
                                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" 
                                           value="{{ old('telefono', $trabajadore?->telefono) }}" id="telefono" placeholder="Teléfono">
                                    {!! $errors->first('telefono', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                                </div>

                            </div>

                            <!-- Botones de Envío y Volver -->
                            <div class="col-md-12 mt-3 text-center">
                                <button type="submit" class="btn btn-warning btn-lg">{{ __('Guardar Trabajador') }}</button>
                                <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary btn-lg ml-3">{{ __('Volver') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .card-header {
            background-color: #343a40; /* Fondo oscuro */
        }
        .card-title {
            font-size: 1.5rem;
        }
        .form-label {
            font-weight: 600;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .form-control:focus {
            border-color: #d4af37; /* Dorado sutil */
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }
        .invalid-feedback {
            font-size: 0.875rem;
            color: #e74a3b;
        }
        .btn-warning {
            background-color: #f39c12;
            border-color: #f39c12;
            font-size: 1rem;
        }
        .btn-warning:hover {
            background-color: #e67e22;
            border-color: #d35400;
        }
        .btn-secondary {
            background-color: #6c757d; /* Color gris para "Volver" */
            border-color: #6c757d;
            font-size: 1rem;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .mt-3 {
            margin-top: 1.5rem;
        }
        .ml-3 {
            margin-left: 1rem;
        }
    </style>
@endpush
