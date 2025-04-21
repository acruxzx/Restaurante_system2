<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Delicia china') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-Dm/eGgqGzYo8FEXBshRPllrW77Bf/Fb9dBa7pLB6IV+MOkU6Mv1U6z1ZQ0C6M8bbFftdG5kQXgZT7BrCoWZbFw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Tempus Dominus CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.2.11/dist/css/tempus-dominus.min.css" />


<!-- Tempus Dominus JS -->
<script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.2.11/dist/js/tempus-dominus.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
               
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
