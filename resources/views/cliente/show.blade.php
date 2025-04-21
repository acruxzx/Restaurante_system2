@extends('layouts.app')

@section('template_title')
    {{ $cliente->name ?? __('Información') . " " . __('Cliente') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-dark">
                    <div class="card-header text-white" style="background-color: #333;">
                        <div class="float-left">
                            <span class="card-title" style="font-weight: bold; font-size: 1.5rem;">{{ __('Informacion del ') }} cliente</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-outline-light btn-sm" href="{{ route('pedidos.create') }}">
                                <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                            </a>
                             <!-- Mostrar el botón de actualizar para todos los usuarios -->
                                <a class="btn btn-sm btn-primary" href="{{ route('clientes.edit', $cliente->id) }}">
                                    <i class="fa fa-fw fa-edit"></i> {{ __('Actualizar información del cliente') }}
                                </a>
                        </div>
                    </div>

                    <div class="card-body" style="background-color: #f4f4f4; color: #333;">
                        <div class="form-group mb-3">
                            <strong class="text-dark" style="font-size: 1.1rem; color: #1a1a1a;">Nombre:</strong>
                            <p style="font-size: 1.1rem; color: #555;">{{ $cliente->nombre }}</p>
                        </div>
                        <div class="form-group mb-3">
                            <strong class="text-dark" style="font-size: 1.1rem; color: #1a1a1a;">Telefono:</strong>
                            <p style="font-size: 1.1rem; color: #555;">{{ $cliente->telefono }}</p>
                        </div>
                        <div class="form-group mb-3">
                            <strong class="text-dark" style="font-size: 1.1rem; color: #1a1a1a;">Barrio:</strong>
                            <p style="font-size: 1.1rem; color: #555;">{{ $cliente->barrio }}</p>
                        </div>
                        <div class="form-group mb-3">
                            <strong class="text-dark" style="font-size: 1.1rem; color: #1a1a1a;">Direccion:</strong>
                            <p style="font-size: 1.1rem; color: #555;">{{ $cliente->direccion }}</p>
                        </div>
                        <div class="form-group mb-3">
                            <strong class="text-dark" style="font-size: 1.1rem; color: #1a1a1a;">Notas:</strong>
                            <p style="font-size: 1.1rem; color: #555;">{{ $cliente->notas }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .card {
            border-radius: 10px;
        }
        .card-header {
            background-color: #222;
            border-bottom: 2px solid #d4af37; /* Dorado sutil */
        }
        .card-body {
            background-color: #fafafa;
            color: #333;
        }
        .btn-outline-light {
            border-color: #d4af37;
            color: #d4af37;
        }
        .btn-outline-light:hover {
            background-color: #d4af37;
            color: #fff;
        }
        .form-group p {
            font-size: 1.1rem;
            color: #555;
        }
    </style>
@endsection
