@extends('layouts.app')

@section('template_title')
    {{ __('Crear') }} Producto
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg mb-4" style="border: 1px solid #D4AF37;">
                    <div class="card-header" style="background-color: #121212; color: #D4AF37; text-align: center;">
                        <h5 class="mb-0">{{ __('Crear Producto') }}</h5>
                    </div>
                    <div class="card-body" style="background-color: #1e1e1e; color: white;">
                        <form method="POST" action="{{ route('productos.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('producto.form')

                            <div class="mt-4 text-center">
                                <button type="submit" class="btn" style="background-color: #D4AF37; color: black;">
                                    {{ __('Guardar Producto') }}
                                </button>
                                <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                                    {{ __('Cancelar') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Estilo general del formulario */
        .form-control {
            background-color: #2c2c2c; /* Fondo oscuro para campos de texto */
            color: white; /* Texto blanco en campos de texto */
            border: 1px solid #D4AF37; /* Borde dorado */
        }

        .form-control:focus {
            background-color: #2c2c2c; /* Fondo oscuro en foco */
            color: white; /* Texto blanco en foco */
            border-color: #D4AF37; /* Borde dorado en foco */
            box-shadow: 0 0 5px #D4AF37; /* Sombra dorada en foco */
        }

        /* Espaciado para mejor legibilidad */
        .mb-3 {
            margin-bottom: 1rem; /* Espacio entre los elementos del formulario */
        }

        /* Botones secundarios */
        .btn-secondary {
            background-color: #121212; /* Fondo oscuro para el botón de cancelar */
            color: #D4AF37; /* Texto dorado para el botón de cancelar */
            border: 1px solid #D4AF37; /* Borde dorado */
        }
        
        /* Hover para botones */
        .btn-secondary:hover {
            background-color: #D4AF37; /* Fondo dorado en hover */
            color: black; /* Texto negro en hover */
        }
    </style>
@endsection
