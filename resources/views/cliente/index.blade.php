@extends('layouts.app')

@section('template_title')
    Clientes
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-lg" style="background-color: #1f1f1f;">
                    <div class="card-header" style="background-color: #333; color: white;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title" style="font-size: 1.5rem; font-weight: 700;">
                                {{ __('Clientes') }}
                            </span>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="color: #333;">
                                <thead class="thead" style="background-color: #222; color: #FFD700;">
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th>Barrio</th>
                                        <th>Direccion</th>
                                        <th>Notas</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $cliente->nombre }}</td>
                                            <td>{{ $cliente->telefono }}</td>
                                            <td>{{ $cliente->barrio }}</td>
                                            <td>{{ $cliente->direccion }}</td>
                                            <td>{{ $cliente->notas }}</td>

                                            <td>
                                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                                                    <a class="btn btn-sm" href="{{ route('clientes.show', $cliente->id) }}" style="background-color: #FFD700; color: black; font-weight: bold;">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('informacion del cliente') }}
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('clientes.edit', $cliente->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> {{ __('Actualizar informacion del cliente') }}
                                                    </a>
                                                    
                                                    @auth
                                                        @php
                                                            $rol = Auth::check() ? Auth::user()->id_rol : null;
                                                        @endphp
                                                        
                                                        <!-- Solo el Administrador (rol == 1) puede ver el botón de eliminar -->
                                                        @if ($rol == 1)
                                                           
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de deshabilitar este cliente?') ? this.closest('form').submit() : false;">
                                                                <i class="fa fa-fw fa-trash"></i> {{ __('eliminar cliente') }}
                                                            </button>
                                                        @endif
                                                    @endauth
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $clientes->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
