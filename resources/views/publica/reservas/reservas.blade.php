@extends('components.layouts.main')

@section('title', 'Reserva')

@section('content')

<section class="relative text-white min-h-screen flex flex-col items-center justify-center py-24 px-6 md:px-16 overflow-hidden">

    <!-- Fondo -->
    <img src="{{ asset('images/comidaelegante.jpg') }}" alt="Fondo elegante"
        class="absolute inset-0 w-full h-full object-cover brightness-50 blur-sm scale-105 -z-10">
    <div class="absolute inset-0 bg-black/50 -z-10"></div>

    <!-- Contenedor principal -->
    <div class="font-serif text-center w-full max-w-5xl">

        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-semibold text-amber-400 mb-3">Realiza tu reserva</h1>
            <a href="{{ route('consultar.reserva') }}" class="text-sm text-gray-300 hover:text-amber-400 transition">
                ¿Ya tienes tu reserva?
            </a>
        </div>

        <!-- Formulario -->
        <form action="{{ route('reservas.store') }}" method="POST"
            class="bg-white/10 backdrop-blur-lg p-10 rounded-3xl border border-white/10 shadow-lg grid md:grid-cols-2 gap-8 text-left">
            @csrf

            <!-- Lado izquierdo -->
            <div class="space-y-4">

                {{-- Nombre --}}
                <div>
                    <label class="block text-amber-400 mb-1">Nombre completo</label>
                    <input type="text" name="client_name" required minlength="8"
                           pattern=".*\s+.*"
                           title="Ingresa nombre y apellido"
                           class="w-full p-2 rounded-lg bg-black/30 border border-white/20 text-white focus:ring-2 focus:ring-amber-400 outline-none">
                </div>

                {{-- Contacto --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-amber-400 mb-1">Contacto</label>
                        <input type="text" name="client_contact" required minlength="10" maxlength="10"
                            pattern="3(0[0-9]|1[0-9]|2[0-9]|5[0-9])[0-9]{7}"
                            title="Debe ser un número colombiano válido (empieza en 300-351, 310-320, etc.)"
                            class="w-full p-2 rounded-lg bg-black/30 border border-white/20 text-white focus:ring-2 focus:ring-amber-400 outline-none">
                    </div>

                    {{-- Documento --}}
                    <div>
                        <label class="block text-amber-400 mb-1">Identificación</label>
                        <input type="text" name="client_document" required minlength="8"
                               pattern="[0-9]{8,}"
                               title="Debe contener al menos 8 números"
                               class="w-full p-2 rounded-lg bg-black/30 border border-white/20 text-white focus:ring-2 focus:ring-amber-400 outline-none">
                    </div>
                </div>

                {{-- Fecha + Hora --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-amber-400 mb-1">Fecha</label>
                        <input type="date" name="reservation_date" required id="reservation_date"
                            class="w-full p-2 rounded-lg bg-black/30 border border-white/20 text-white focus:ring-2 focus:ring-amber-400 outline-none">
                    </div>

                    <div>
                        <label class="block text-amber-400 mb-1">Hora de llegada</label>
                        <select name="reservation_time" required
                            class="w-full p-2 rounded-lg bg-black/30 border border-white/20 text-white focus:ring-2 focus:ring-amber-400 outline-none">

                            @php
                                $start = strtotime("07:00");
                                $end   = strtotime("23:00");
                                while ($start <= $end) {
                                    echo '<option value="' . date("H:i", $start) . '">' . date("H:i", $start) . '</option>';
                                    $start = strtotime("+90 minutes", $start);
                                }
                            @endphp

                        </select>
                    </div>
                </div>

                {{-- Asistentes --}}
                <div>
                    <label class="block text-amber-400 mb-1">Número de asistentes</label>
                    <input type="number" name="people_count" required min="1"
                        class="w-full p-2 rounded-lg bg-black/30 border border-white/20 text-white focus:ring-2 focus:ring-amber-400 outline-none">
                </div>
            </div>

            <!-- Lado derecho -->
            <div>
                <div class="mt-6">
                    <label class="block text-amber-400 mb-2">Notas adicionales</label>
                    <textarea name="notes" rows="6"
                        class="w-full p-3 rounded-lg bg-black/30 border border-white/20 text-white resize-none focus:ring-2 focus:ring-amber-400 outline-none"
                        placeholder="Ejemplo: Cumpleaños, alergias, solicitud especial..."></textarea>
                </div>
            </div>

            <!-- Botón -->
            <div class="md:col-span-2 flex justify-center mt-10">
                <button type="submit"
                    class="bg-amber-400 text-black px-8 py-3 rounded-full hover:cursor-pointer hover:bg-amber-500 transition font-semibold shadow-md">
                    Confirmar reserva
                </button>
            </div>

        </form>
    </div>

</section>

{{-- Script: no permitir fechas anteriores --}}
<script>
    const today = new Date().toISOString().split("T")[0];
    document.getElementById("reservation_date").setAttribute("min", today);
</script>

@endsection
