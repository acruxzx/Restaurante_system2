<div class="row justify-content-center padding-1 p-1">
    <div class="col-md-6">
        <div class="card shadow-sm mb-4" style="border-radius: 8px; border: 1px solid #FFD700;">
            <div class="card-header text-center" style="background-color: #000000; color: #FFD700; font-weight: bold;">
                <h5 class="mb-0">{{ __('Agregar Tamaño') }}</h5>
            </div>
            <div class="card-body" style="background-color: #f9f9f9;">
                <form action="{{ route('tamanos.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="nombre" class="form-label" style="color: #000000; font-weight: bold;">{{ __('Nombre') }}</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre', $tamano?->nombre) }}" id="nombre" placeholder="Nombre" 
                               style="border: 1px solid #FFD700; background-color: #f0f0f0;">
                        {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
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
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos personalizados */
    .form-label {
        color: #000000; /* Etiquetas de color negro */
    }

    .btn-warning {
        background-color: #FFD700; /* Botón dorado */
        border: none;
        font-weight: bold;
        color: #000000;
    }

    .card {
        border-radius: 8px;
    }

    .card-header {
        background-color: #000000;
        color: #FFD700;
        font-weight: bold;
    }

    .card-body {
        background-color: #f9f9f9;
    }

    .form-control {
        border: 1px solid #FFD700;
        background-color: #f0f0f0;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        color: #dc3545;
    }

    .text-center {
        text-align: center;
    }
</style>
