<!-- resources/views/admin/abrir_caja.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Abrir Caja</h2>
    <form action="{{ route('admin.caja.abrir') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_num_caja">Caja:</label>
            <select name="id_num_caja" class="form-control" required>
                @foreach($numCajas as $numCaja)
                    <option value="{{ $numCaja->id }}">{{ $numCaja->caja }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="base_inicial">Base Inicial:</label>
            <input type="number" name="base_inicial" class="form-control" required min="0">
        </div>
        <button type="submit" class="btn btn-primary">Abrir Caja</button>
    </form>
</div>
@endsection
