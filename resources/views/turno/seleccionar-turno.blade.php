@extends('layouts.app')

@section('content')
    <!-- Contenedor principal para el formulario flotante -->
    <div class="overlay">
        <div class="form-container">
            <h2>Seleccionar Turno</h2>
            <!-- Formulario para seleccionar el turno -->
            <form action="{{ route('turno.guardar') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="turno">Selecciona tu turno</label>
                    <select id="turno" name="turno" class="form-control">
                        <option value="dia">Dia</option>
                        <option value="noche">Noche</option>
                    </select>
                </div>
                <button type="submit" class="btn">Confirmar</button>
            </form>
        </div>
    </div>

    <style>
        /* Fondo oscuro semi-transparente */
        .overlay {
            position: fixed; /* Asegura que el contenedor cubra toda la pantalla */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7); /* Fondo oscuro con algo de transparencia */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Asegura que esté encima de otros elementos */
        }

        /* Estilo del contenedor del formulario */
        .form-container {
            background-color: #1a1a1a; /* Fondo oscuro (negro) */
            color: white; /* Texto blanco */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 400px;
            text-align: center;
            transition: all 0.3s ease;
            z-index: 10000; /* Asegura que el contenedor esté encima del fondo */
        }

        /* Título de la ventana */
        .form-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #d4af37; /* Color dorado */
        }

        /* Estilo del formulario */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        select {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
            border-radius: 5px;
        }

        select:focus {
            outline: none;
            border-color: #d4af37; /* Borde dorado al hacer foco */
        }

        /* Botón de confirmación */
        .btn {
            background-color: #d4af37; /* Color dorado */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        /* Cambiar color del botón cuando se pase el ratón */
        .btn:hover {
            background-color: #b38b2e; /* Un dorado más oscuro */
        }
    </style>
@endsection
