<x-layouts.app :title="__('Asignar Mesa a Reserva')">

    <section class="relative w-full rounded-2xl overflow-hidden shadow-lg">
        <img src="{{ asset('images/Restaurante.jpg') }}"
             class="absolute inset-0 w-full h-full object-cover brightness-[0.5]">
        <div class="relative z-10 p-10 text-white">
            <h2 class="text-4xl font-serif font-bold">🍽️ Asignar Mesa</h2>
            <p class="text-amber-300 text-lg">Gestiona la reserva y selecciona la mesa ideal</p>
        </div>
    </section>

    <div class="flex h-full w-full flex-1 flex-col gap-10 mt-6">

        <!-- CARD Principal -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-8 shadow-sm">

            <!-- Título -->
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                Información de la Reserva
                <span class="text-sm px-3 py-1 rounded-full bg-amber-200 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                    {{ ucfirst($reservation->status) }}
                </span>
            </h2>

            <!-- Información de la reserva -->
            <div class="grid md:grid-cols-2 gap-6 mb-10">

                <div class="bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
                    <p class="text-sm text-neutral-500">Cliente</p>
                    <p class="text-xl font-semibold">{{ $reservation->client_name }}</p>
                </div>

                <div class="bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
                    <p class="text-sm text-neutral-500">Fecha y Hora</p>
                    <p class="text-xl font-semibold">
                        {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('d M, h:i A') }}
                    </p>
                </div>

                <div class="bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
                    <p class="text-sm text-neutral-500">Personas</p>
                    <p class="text-xl font-semibold">{{ $reservation->people_count }}</p>
                </div>

            </div>

            <!-- Selección de mesa -->
            <form action="{{ route('tables.assign.store', $reservation->id) }}" method="POST">
                @csrf

                <h3 class="text-xl font-semibold mb-4">Selecciona una Mesa Disponible</h3>

                @if($tables->isEmpty())
                    <div class="p-4 bg-red-100 text-red-700 rounded-lg border border-red-300 mb-6">
                        No hay mesas disponibles actualmente.
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 mb-10">

                        @foreach($tables as $table)
                            <label class="cursor-pointer">

                                <input type="radio" name="table_id" value="{{ $table->id }}" class="peer hidden" required>

                                <div class="
                                    border rounded-2xl p-5 text-center transition-all shadow-sm
                                    bg-white dark:bg-neutral-800 dark:border-neutral-700
                                    peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-900/20
                                ">
                                    <p class="text-lg font-bold mb-1">
                                        Mesa {{ $table->number }}
                                    </p>

                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-2">
                                        Capacidad: {{ $table->capacity }}
                                    </p>

                                    <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                        Disponible
                                    </span>
                                </div>

                            </label>
                        @endforeach

                    </div>
                @endif

                <!-- Botones -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 rounded-xl bg-neutral-200 hover:bg-neutral-300 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-neutral-700 dark:text-neutral-200 transition">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="px-6 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white shadow-sm transition">
                        Confirmar Asignación
                    </button>
                </div>

            </form>

        </div>
    </div>

</x-layouts.app>
