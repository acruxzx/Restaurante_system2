@extends('layouts.app')

@section('template_title')
    {{ __('Crear') }} Precio
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card border-light shadow-sm mb-3">
                    <div class="card-header" style="background-color: #000000; color: #FFD700;">
                        <span class="card-title">{{ __('Crear') }} Precio</span>
                    </div>

                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('precios.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('precio.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<style>
    .card-header {
        background-color: #000000; /* Color de fondo de la cabecera */
        color: #FFD700; /* Color del texto */
    }
    .card-body {
        background-color: #f0f0f0; /* Color de fondo del cuerpo de la tarjeta */
    }
    .form-label {
        color: #000000; /* Color de las etiquetas */
    }
    .btn-warning {
        background-color: #FFD700; /* Color dorado para los botones */
        border: none; /* Sin borde */
    }
</style>
