@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Tp Usuario
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Tp Usuario</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('tp-usuarios.update', $tpUsuario->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('tp-usuario.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
