@extends('components.layouts.main')

@section('title', 'Resultado de la reserva')

@section('content')

<section class="relative text-white min-h-screen flex flex-col items-center justify-center py-24 px-6 md:px-16 overflow-hidden">

    <!-- Fondo -->
    <img src="{{ asset('images/comidaelegante.jpg') }}" 
         alt="Fondo elegante"
         class="absolute inset-0 w-full h-full object-cover brightness-50 blur-sm scale-105 -z-10">
    <div class="absolute inset-0 bg-black/50 -z-10"></div>

    <!-- Contenido principal -->
    <div class="w-full max-w-3xl text-center font-serif">

        <!-- Título -->
        <div class="mb-10">
            <h1 class="text-4xl md:text-5xl font-semibold text-amber-400 mb-3">Resultado de tu consulta</h1>
            <p class="text-sm text-gray-300">Mostrando resultados para el documento: 
                <span class="text-amber-300 font-medium">{{ $query }}</span>
            </p>
        </div>

        <!-- Si hay reservas -->
        @if($reservas->isNotEmpty())
            <div class="space-y-8">
                @foreach($reservas as $reserva)
                    <div class="bg-white/10 backdrop-blur-lg p-8 rounded-3xl border border-white/10 shadow-lg text-left">
                        <h3 class="text-amber-400 text-2xl font-semibold mb-4">
                            Reserva #{{ $reserva->id }}
                        </h3>

                        <div class="space-y-2 text-gray-200">
                            <p><span class="font-semibold text-amber-300">Nombre:</span> {{ $reserva->client_name }}</p>
                            <p><span class="font-semibold text-amber-300">Documento:</span> {{ $reserva->cliente_document }}</p>
                            <p><span class="font-semibold text-amber-300">Contacto:</span> {{ $reserva->client_contact }}</p>
                            <p><span class="font-semibold text-amber-300">Fecha y hora:</span> {{ \Carbon\Carbon::parse($reserva->reservation_time)->format('d/m/Y H:i') }}</p>
                            <p><span class="font-semibold text-amber-300">Asistentes:</span> {{ $reserva->people_count }} personas</p>
                            <p><span class="font-semibold text-amber-300">Mesa:</span> {{ $reserva->table->name ?? 'No especificada' }}</p>
                            <p><span class="font-semibold text-amber-300">Mesero asignado:</span> {{ $reserva->user->name ?? 'No asignado' }}</p>

                            {{-- <!-- Estado -->
                            <p class="mt-3">
                                <span class="font-semibold text-amber-300">Estado:</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($reserva->status === 'confirmada') bg-green-500/20 text-green-300
                                    @elseif($reserva->status === 'pendiente') bg-yellow-500/20 text-yellow-300
                                    @elseif($reserva->status === 'cancelada') bg-red-500/20 text-red-300
                                    @else bg-gray-500/20 text-gray-300 @endif">
                                    {{ ucfirst($reserva->status) }}
                                </span>
                            </p>
                        </div> --}}
                    </div>
                @endforeach
            </div>
        @else
            <!-- Si no hay reservas -->
            <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/10 shadow-lg">
                <p class="text-gray-300 text-lg">❌ No se encontró ninguna reserva asociada a ese documento.</p>
            </div>
        @endif

        <!-- Botón para volver -->
        <div class="mt-12">
            <a href="{{ route('consultar.reserva') }}"
               class="inline-block bg-amber-400 text-black px-8 py-3 rounded-full font-semibold hover:bg-amber-500 transition shadow-md">
                🔙 Volver al formulario
            </a>
        </div>

    </div>

</section>

@endsection
