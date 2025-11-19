<x-layouts.app :title="__('Dashboard Recepción')">

    <div class="flex h-full w-full flex-1 flex-col gap-6">

        <!-- Encabezado -->
        <div class="bg-gradient-to-r from-purple-500 to-pink-600 dark:from-purple-700 dark:to-pink-800 rounded-xl p-8 text-white">
            <h2 class="text-3xl font-bold mb-2">📞 Recepción - Panel de Control</h2>
            <p class="text-purple-100">Gestión de reservas y estado de mesas</p>
        </div>

        <!-- Estadísticas -->
        <div class="grid gap-4 md:grid-cols-3">

            <!-- Reservas hoy -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Reservas Hoy</p>
                        <p class="text-3xl font-semibold mt-2">{{ $stats['reservations_today'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Próximas reservas -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Próximas Reservas</p>
                        <p class="text-3xl font-semibold mt-2">{{ $upcomingReservations->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Mesas Ocupadas -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Mesas Ocupadas</p>
                        <p class="text-3xl font-semibold mt-2">{{ $stats['tables_occupied'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 10h18M3 14h18m-9-4v8"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Acciones -->
        <div class="grid gap-4 md:grid-cols-2">
            <a href="{{ route('reservations.create') }}"
               class="flex items-center gap-4 p-6 bg-white dark:bg-neutral-800 rounded-xl border-2 border-dashed hover:border-purple-500 transition">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Nueva Reserva</p>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Crear registro de reserva</p>
                </div>
            </a>

            <a href="{{ route('tables.map') }}"
               class="flex items-center gap-4 p-6 bg-white dark:bg-neutral-800 rounded-xl border-2 border-dashed hover:border-green-500 transition">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 20l6-3m0 0l6-3m-6 3V4L9 7v13l-5.5-2.7A1 1 0 013 16.4V5.6A1 1 0 014.5 4.7L9 7"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Mapa de Mesas</p>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Estado del restaurante</p>
                </div>
            </a>
        </div>

        <!-- Reservas Pendientes -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border p-6 mt-4">
            <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
                🕒 Reservas Pendientes
                <span class="text-sm px-3 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">
                    {{ $pendingReservations->count() }}
                </span>
            </h3>

            <div class="space-y-3 max-h-96 overflow-y-auto">

                @forelse ($pendingReservations as $reservation)
                    <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg border">

                        <!-- Info del cliente -->
                        <div>
                            <p class="font-semibold">{{ $reservation->client_name }}</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                {{ $reservation->people_count }} personas
                            </p>
                            <p class="text-xs text-neutral-500">
                                {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('d M - H:i') }}
                            </p>
                        </div>

                        <!-- Botón Asignar Mesa -->
                        <a href="{{ route('tables.assign', $reservation->id) }}"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Asignar Mesa
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-neutral-500 text-center py-8">
                        No hay reservas pendientes
                    </p>
                @endforelse

            </div>
        </div>


        <!-- Próximas reservas -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border p-6">
            <h3 class="text-xl font-semibold mb-6">Próximas Reservas</h3>

            <div class="space-y-3 max-h-96 overflow-y-auto">
                @forelse($upcomingReservations as $reservation)
                    <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
                        <div>
                            <p class="font-medium">{{ $reservation->client_name }}</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                {{ $reservation->people_count }} personas
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium">
                                {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('d M') }}
                            </p>
                            <p class="text-xs text-neutral-500">
                                {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-neutral-500 text-center py-8">No hay reservas próximas</p>
                @endforelse
            </div>
        </div>

        <!-- Órdenes Activas -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border p-6">
            <h3 class="text-xl font-semibold mb-6">Órdenes Activas</h3>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($activeOrders as $order)
                    <div class="p-4 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg border">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold">Mesa {{ $order->table->number }}</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ $order->orderItems->count() }} items
                        </p>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-neutral-500 py-8">No hay órdenes activas</p>
                @endforelse
            </div>
        </div>


    </div>

</x-layouts.app>
