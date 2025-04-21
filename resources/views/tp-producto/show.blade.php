@extends('layouts.app')

@section('template_title')
    {{ $tpProducto->name ?? __('Show') . " " . __('Tp Producto') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Tp Producto</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('tp-productos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Tipo Producto:</strong>
                                    {{ $tpProducto->tipo_producto }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
