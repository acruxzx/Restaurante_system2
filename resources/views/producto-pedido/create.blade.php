@extends('layouts.app')

@section('template_title')
   
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card shadow-sm" style="border-radius: 10px; background-color: #f8f9fa;">
                    <div class="card-header bg-black text-white text-center">
                        <span class="card-title h5">Delicia China</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('producto-pedidos.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('producto-pedido.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<style>
    .card {
        border-radius: 10px; /* Bordes redondeados */
    }

    .card-header {
        border-bottom: 2px solid #fff; /* Línea blanca en la parte inferior */
    }

    .bg-primary {
        background-color: #007bff !important; /* Color del encabezado de la tarjeta */
    }

    .bg-white {
        background-color: #ffffff !important; /* Fondo blanco para el cuerpo de la tarjeta */
    }

    /* Estilo para el formulario */
    form {
        padding: 20px; /* Espaciado interno */
    }

    .form-control {
        border-radius: 5px; /* Bordes redondeados en los campos de entrada */
    }
</style>
