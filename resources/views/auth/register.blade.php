<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-gray-800 to-black p-6">
        <div class="bg-white rounded-lg shadow-2xl p-8 w-full max-w-lg">
            <!-- Header con Icono de Restaurante -->
            <div class="text-center mb-6">
                <h2 class="text-3xl font-extrabold text-gray-900">¡Bienvenido al Registro de Usuario!</h2>
                <p class="text-gray-500 mt-2">Únete a nuestra comunidad y disfruta de lo mejor</p>
                <div class="mt-6">
                    <i class="fas fa-utensils text-yellow-500 text-5xl"></i>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Cedula -->
                <div class="mb-5">
                    <x-input-label for="cedula" :value="__('Cédula')" />
                    <x-text-input id="cedula" class="block mt-1 w-full border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200" type="number" name="cedula" :value="old('cedula')" required autofocus autocomplete="cedula" />
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>

                <!-- Nombre -->
                <div class="mb-5">
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" class="block mt-1 w-full border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200" type="text" name="name" :value="old('name')" required autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Apellido -->
                <div class="mb-5">
                    <x-input-label for="apellido" :value="__('Apellido')" />
                    <x-text-input id="apellido" class="block mt-1 w-full border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200" type="text" name="apellido" :value="old('apellido')" required autocomplete="apellido" />
                    <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                </div>

                <!-- Teléfono -->
                <div class="mb-5">
                    <x-input-label for="telefono" :value="__('Teléfono')" />
                    <x-text-input id="telefono" class="block mt-1 w-full border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200" type="text" name="telefono" :value="old('telefono')" required autocomplete="telefono" />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <!-- Dirección -->
                <div class="mb-5">
                    <x-input-label for="direccion" :value="__('Dirección')" />
                    <x-text-input id="direccion" class="block mt-1 w-full border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200" type="text" name="direccion" :value="old('direccion')" required autocomplete="direccion" />
                    <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                </div>

                <!-- Rol (Sin opción de administrador) -->
                <div class="mb-5">
                    <x-input-label for="rol" :value="__('Rol')" />
                    <select name="id_rol" id="id_rol" class="block mt-1 w-full border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200">
                        @foreach ($rol as $r)
                            @if($r->rol !== 'Administrador') <!-- Excluyendo el rol de Administrador -->
                                <option value="{{ $r->id }}">{{ $r->rol }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- Email -->
                <div class="mb-5">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Contraseña -->
                <div class="mb-5">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-5">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Botón de Registro -->
                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('¿Ya tienes una cuenta? Inicia sesión') }}
                    </a>
                    <x-primary-button class="bg-yellow-500 hover:bg-yellow-600 text-gray-800 font-bold py-2 px-4 rounded-md transition duration-300">
                        {{ __('Registrarse') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
