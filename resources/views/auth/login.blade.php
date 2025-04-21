<x-guest-layout>
    <!-- Estilos mejorados -->
    <style>
        /* Fondo animado con degradado */
        body {
            background: linear-gradient(135deg, #1e1e2f, #2c2c3e, #3a3a4d);
            animation: gradientMove 15s ease infinite;
            background-size: 400% 400%;
            color: #f5f5f5;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        @keyframes gradientMove {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }

        /* Contenedor principal */
        .form-container {
            max-width: 420px;
            margin: 60px auto;
            padding: 40px;
            background-color: rgba(0, 0, 1, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
            border: 1px solid #444;
        }

        /* Logo */
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            max-width: 300px;
            border-radius: 50%;
            border: 6px solid #806f13;
        }

       

        /* Labels */
        .input-label {
            font-weight: 600;
            color: #FFD700;
            font-size: 14px;
        }

        /* Inputs */
        .input-field {
            background-color: #2e2e4e;
            color: #f5f5f5;
            border: 1px solid #555;
            border-radius: 10px;
            padding: 12px 16px;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 15px;
            transition: border 0.3s ease, box-shadow 0.3s ease;
        }

        .input-field:focus {
            border-color: #FFD700;
            outline: none;
            box-shadow: 0 0 8px #FFD700;
        }

        /* Botón */
        .primary-button {
            background-color: #FFD700;
            color: #1e1e2f;
            border: none;
            border-radius: 10px;
            padding: 14px;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .primary-button:hover {
            background-color: #e6c200;
            transform: scale(1.03);
        }

        /* Recordarme */
        .remember-me label {
            color: #ccc;
            font-size: 14px;
        }

        /* Link contraseña */
        .forgot-password-link {
            color: #aaa;
            text-decoration: none;
            font-size: 13px;
            margin-top: 10px;
            display: inline-block;
            transition: color 0.3s ease;
        }

        .forgot-password-link:hover {
            color: #FFD700;
        }

        /* Enlaces y espaciado */
        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mt-4 {
            margin-top: 20px;
        }
    </style>

    <div class="form-container">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('storage/images/logores.jpg') }}" alt="Logo"> 
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Correo Electrónico')" class="input-label" />
                <x-text-input id="email" class="input-field" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div>
                <x-input-label for="password" :value="__('Contraseña')" class="input-label" />
                <x-text-input id="password" class="input-field" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Recordarme -->
            <div class="block mt-2 remember-me">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-yellow-500 shadow-sm focus:ring-yellow-300" name="remember">
                    <span class="ml-2 text-sm">{{ __('Recuérdame') }}</span>
                </label>
            </div>

            <!-- Enlaces -->
            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="forgot-password-link" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </div>

            <!-- Botón -->
            <div class="mt-4">
                <x-primary-button class="primary-button">
                    {{ __('Iniciar sesión') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
