<x-layouts.app :title="__('Asignar Mesa a Reserva')">

    <div class="flex h-full w-full flex-col gap-6">

        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">

            <h2 class="text-2xl font-bold mb-4">Asignar Mesa a Reserva</h2>

            <!-- Información de la reserva -->
            <div class="p-4 bg-black-50 dark:bg-neutral-700/40 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-2">Información de la Reserva</h3>
                <p><strong>Cliente:</strong> {{ $reservation->client_name }}</p>
                <p><strong>Fecha y hora:</strong> {{ $reservation->reservation_time }}</p>
                <p><strong>Personas:</strong> {{ $reservation->people_count }}</p>
                <p><strong>Estado:</strong> 
                    <span class="px-2 py-1 rounded bg-yellow-600 text-sm">
                        {{ ucfirst($reservation->status) }}
                    </span>
                </p>
            </div>

            <!-- Selección de mesa -->
            <form action="{{ route('tables.assign.store', $reservation->id) }}" method="POST">
                @csrf

                <h3 class="text-lg font-semibold mb-2">Selecciona una Mesa</h3>

                @if($tables->isEmpty())
                    <div class="p-4 bg-red-100 text-red-700 rounded mb-4">
                        No hay mesas disponibles en este momento.
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">

                        @foreach($tables as $table)
                            <label class="cursor-pointer">
                                <input type="radio" name="table_id" value="{{ $table->id }}" class="peer hidden" required>

                                <div class="border-2 rounded-lg p-4 text-center transition-all
                                    peer-checked:border-blue-500 peer-checked:bg-blue-50
                                    bg-white dark:bg-neutral-800 dark:border-neutral-700">

                                    <div class="text-xl font-bold mb-1">
                                        Mesa {{ $table->number }}
                                    </div>

                                    <div class="text-sm text-neutral-600 dark:text-neutral-400 mb-1">
                                        Capacidad: {{ $table->capacity }}
                                    </div>

                                    <span class="text-xs px-2 py-1 rounded bg-green-500 text-white">
                                        Disponible
                                    </span>
                                </div>
                            </label>
                        @endforeach

                    </div>
                @endif

                <div class="flex justify-end gap-2">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Asignar Mesa
                    </button>
                </div>

            </form>
        </div>
    </div>

</x-layouts.app>
