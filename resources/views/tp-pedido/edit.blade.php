@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Tp Pedido
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Tp Pedido</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('tp-pedidos.update', $tpPedido->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('tp-pedido.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
