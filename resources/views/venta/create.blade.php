@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Venta
@endsection

@section('content')
    <section class="content container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6 col-lg-4">

                <div class="card shadow-lg border-light" style="border-radius: 15px; background-color: #ffffff;">
                    <div class="card-header text-center" style="background-color: #000000; color: #FFD700; border-radius: 15px 15px 0 0;">
                        <span class="card-title">{{ __('Create') }} Venta</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('ventas.store') }}" role="form" enctype="multipart/form-data">
                            @csrf
                            @include('venta.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
