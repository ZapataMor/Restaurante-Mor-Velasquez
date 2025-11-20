<x-layouts.app :title="__('Mapa de Mesas')">

    <!-- ENCABEZADO -->
    <section class="relative w-full rounded-2xl overflow-hidden shadow-lg">
        <img src="{{ asset('images/Restaurante.jpg') }}"
             class="absolute inset-0 w-full h-full object-cover brightness-[0.45]">
        <div class="relative z-10 p-10 text-white">
            <h2 class="text-4xl font-serif font-bold">🗺️ Mapa de Mesas</h2>
            <p class="text-amber-300 text-lg">Vista general de disponibilidad y actividad</p>
        </div>
    </section>

    <div class="mt-8 flex h-full w-full flex-1 flex-col gap-10">

        <!-- ACCIONES SUPERIORES -->
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-semibold">Mesas del Restaurante</h3>
            <div class="flex gap-3">
                <a href="{{ route('tables.index') }}"
                    class="px-4 py-2 rounded-xl bg-neutral-200 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-300 dark:hover:bg-neutral-600 transition shadow-sm">
                    Ver Lista
                </a>

                <button onclick="location.reload()"
                    class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm">
                    Actualizar
                </button>
            </div>
        </div>

        <!-- LEYENDA -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h4 class="text-lg font-semibold mb-4">Leyenda</h4>

            <div class="flex flex-wrap gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-green-500"></div>
                    <span class="text-sm">Disponible</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-red-500"></div>
                    <span class="text-sm">Ocupada</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-yellow-500"></div>
                    <span class="text-sm">Reservada</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-gray-500"></div>
                    <span class="text-sm">Necesita Limpieza</span>
                </div>
            </div>
        </div>

        <!-- GRID DE MESAS -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

            @foreach($tables as $table)
                @php
                    $borderColors = [
                        'Disponible' => 'border-green-500',
                        'Ocupada' => 'border-red-500',
                        'Reservada' => 'border-yellow-500',
                        'Necesita Limpieza' => 'border-gray-500',
                    ];

                    $badgeColors = [
                        'Disponible' => 'bg-green-500',
                        'Ocupada' => 'bg-red-500',
                        'Reservada' => 'bg-yellow-500',
                        'Necesita Limpieza' => 'bg-gray-500',
                    ];
                @endphp

                <div class="bg-white dark:bg-neutral-900 rounded-2xl border-2 {{ $borderColors[$table->status] ?? 'border-gray-500' }} 
                            p-6 shadow-sm hover:shadow-md transition hover:scale-[1.02]">

                    <!-- Número de mesa -->
                    <p class="text-3xl font-bold mb-3">Mesa {{ $table->number }}</p>

                    <!-- Estado -->
                    <span class="text-xs text-white px-2 py-1 rounded {{ $badgeColors[$table->status] }}">
                        {{ $table->status }}
                    </span>

                    <!-- Capacidad -->
                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-3">
                        Capacidad: {{ $table->capacity }} personas
                    </p>

                    <!-- Órdenes activas -->
                    @if($table->orders->isNotEmpty())
                        <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                            <p class="text-sm font-semibold mb-2">Órdenes Activas:</p>

                            @foreach($table->orders->take(2) as $order)
                                <div class="p-3 mb-2 bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700">
                                    <p class="font-medium text-sm">Orden #{{ $order->id }}</p>
                                    <p class="text-xs text-neutral-600 dark:text-neutral-400">
                                        {{ $order->user->name ?? 'Sin mesero' }}
                                    </p>

                                    <span class="inline-block mt-2 px-2 py-0.5 text-xs rounded text-white
                                        @if($order->status === 'En Vista') bg-gray-500
                                        @elseif($order->status === 'Confirmada') bg-blue-500
                                        @elseif($order->status === 'En Preparación') bg-yellow-500
                                        @elseif($order->status === 'Lista') bg-green-500
                                        @endif">
                                        {{ $order->status }}
                                    </span>

                                    <p class="text-xs mt-1">{{ $order->orderItems->count() }} items</p>
                                </div>
                            @endforeach

                            @if($table->orders->count() > 2)
                                <p class="text-xs text-neutral-500 mt-1">
                                    +{{ $table->orders->count() - 2 }} más
                                </p>
                            @endif
                        </div>
                    @endif

                    <!-- ACCIONES -->
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('tables.show', $table->id) }}"
                            class="flex-1 text-xs text-center px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition">
                            Ver
                        </a>

                        @if($table->status === 'Disponible')
                            <a href="{{ route('orders.create') }}?table_id={{ $table->id }}"
                                class="flex-1 text-xs text-center px-3 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-white transition">
                                Orden
                            </a>
                        @endif
                    </div>

                </div>
            @endforeach

        </div>

        <!-- SIN MESAS -->
        @if($tables->isEmpty())
            <div class="text-center py-12">
                <p class="text-neutral-500">No hay mesas registradas</p>
                <a href="{{ route('tables.create') }}"
                   class="mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow">
                    Crear Primera Mesa
                </a>
            </div>
        @endif

    </div>

    <!-- Auto-refresh cada 30s -->
    <script>
        setTimeout(() => location.reload(), 30000);
    </script>

</x-layouts.app>
