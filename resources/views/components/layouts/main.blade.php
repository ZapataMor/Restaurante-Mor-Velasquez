<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restaurante Mor Velasquez')</title>
    @vite('resources/css/app.css') 
    @vite('resources/js/app.js')
</head>

<body class="{{ Route::is('inicio') ? 'bg-transparent' : 'bg-white' }}">
    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Contenido principal --}}
    <main class="pt-0 pb-0">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    <style>
        body.bg-transparent {
            background-color: transparent !important;
        }
    </style>
</body>

</html>
