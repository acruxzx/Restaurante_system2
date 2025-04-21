@extends('layouts.app')

@section('template_title')
    {{ __('Agregar Tipo de Producto') }}
@endsection

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 100vh; background-color: #f8f9fa;">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0" style="background-color: #ffffff;">
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4" style="color: #000; font-weight: bold;">
                    {{ __('Agregar Tipo de Producto') }}
                </h5>
                
                <form method="POST" action="{{ route('tp-productos.store') }}" role="form" enctype="multipart/form-data">
                    @csrf
                    @include('tp-producto.form') <!-- Aquí se incluye el formulario -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
