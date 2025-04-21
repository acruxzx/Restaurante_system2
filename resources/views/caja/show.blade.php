@extends('layouts.app')

@section('template_title')
    {{ $caja->name ?? __('Show') . " " . __('Caja') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Caja</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('cajas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Egreso:</strong>
                                    {{ $caja->egreso }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Inicio:</strong>
                                    {{ $caja->inicio }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fin:</strong>
                                    {{ $caja->fin }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Trabajador:</strong>
                                    {{ $caja->id_trabajador }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Num Caja:</strong>
                                    {{ $caja->id_num_caja }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
