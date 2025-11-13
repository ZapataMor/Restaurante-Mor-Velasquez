@extends('components.layouts.main')

@section('title', 'Consultar reserva')

@section('content')

<section class="relative text-white min-h-screen flex flex-col items-center justify-center py-24 px-6 md:px-16 overflow-hidden">

    <!-- Fondo -->
    <img src="{{ asset('images/comidaelegante.jpg') }}" 
         alt="Fondo elegante"
         class="absolute inset-0 w-full h-full object-cover brightness-50 blur-sm scale-105 -z-10">
    <div class="absolute inset-0 bg-black/50 -z-10"></div>

    <!-- Contenido principal -->
    <div class="w-full max-w-3xl text-center font-serif">

        <div class="mb-10">
            <h1 class="text-4xl md:text-5xl font-semibold text-amber-400 mb-3">Consulta tu reserva</h1>
            <a href="{{ route('reservas.index') }}" class="text-sm text-gray-300 hover:text-amber-400 transition">
                ¿Aún no tienes una reserva?
            </a>
        </div>

        <!-- Mensajes de alerta -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-600/30 border border-green-400 rounded-lg text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-600/30 border border-red-400 rounded-lg text-red-200">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulario -->
        <form method="GET" action="{{ route('consultar.buscar') }}"
            class="bg-white/10 backdrop-blur-lg p-10 rounded-3xl border border-white/10 shadow-lg space-y-6 text-left">

            <div>
                <label class="block text-amber-400 mb-1">Número de identificación</label>
                <input type="text" name="query" placeholder="Ingresa tu cédula o documento" 
                    class="w-full p-3 rounded-lg bg-black/30 border border-white/20 text-white placeholder-gray-400 focus:ring-2 focus:ring-amber-400 outline-none">
            </div>

            <div class="flex justify-center pt-4">
                <button type="submit"
                        class="bg-amber-400 text-black px-8 py-3 rounded-full hover:bg-amber-500 transition font-semibold shadow-md">
                    Buscar reserva
                </button>
            </div>
        </form>


        <!-- Resultado de la búsqueda -->
        @isset($reserva)
            <div class="mt-12 bg-black/30 backdrop-blur-md p-8 rounded-2xl border border-white/10 text-left">
                <h3 class="text-amber-400 text-2xl font-semibold mb-4">Detalles de tu reserva</h3>
                <p><span class="font-semibold">Nombre:</span> {{ $reserva->client_name }}</p>
                <p><span class="font-semibold">Documento:</span> {{ $reserva->cliente_document }}</p>
                <p><span class="font-semibold">Contacto:</span> {{ $reserva->client_contact }}</p>
                <p><span class="font-semibold">Fecha y hora:</span> {{ \Carbon\Carbon::parse($reserva->reservation_time)->format('d/m/Y H:i') }}</p>
                <p><span class="font-semibold">Asistentes:</span> {{ $reserva->people_count }} personas</p>
                <p><span class="font-semibold">Mesa:</span> {{ $reserva->table->name ?? 'No especificada' }}</p>
            </div>
        @endisset

    </div>

</section>

@endsection
