@extends('layouts.app')

@section('template_title')
    {{ __('Cierre de Caja') }}
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-light">
                <div class="card-header bg-dark text-warning">
                    <h5 class="mb-0">{{ __('Cierre de Caja') }} - {{ $numCaja->caja }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('cierres_caja.store', $numCaja->id) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="base_inicial" class="text-dark">{{ __('Base Inicial') }}</label>
                            <input type="text" id="base_inicial" class="form-control" value="{{ number_format($numCaja->base_inicial, 2) }}" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="total_turno" class="text-dark">{{ __('Total del Turno') }}</label>
                            <input type="number" step="0.01" id="total_turno" name="total_turno" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="saldo_final" class="text-dark">{{ __('Saldo Final') }}</label>
                            <input type="number" step="0.01" id="saldo_final" name="saldo_final" class="form-control" required>
                        </div>

                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-success">{{ __('Cerrar Caja') }}</button>
                            <a href="{{ route('num-cajas.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
