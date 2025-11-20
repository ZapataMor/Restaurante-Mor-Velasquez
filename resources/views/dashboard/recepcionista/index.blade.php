<x-layouts.app :title="__('Dashboard Recepción')">

    <!-- HERO Superior estilo Mor Velasquez -->
    <section class="relative w-full rounded-2xl overflow-hidden shadow-lg">
        <img src="{{ asset('images/Restaurante.jpg') }}"
             class="absolute inset-0 w-full h-full object-cover brightness-[0.45]">
        <div class="relative z-10 p-10 text-white">
            <h2 class="text-4xl font-serif font-bold">📞 Recepción</h2>
            <p class="text-amber-300 text-lg">Panel de control de reservas y mesas</p>
        </div>
    </section>

    <div class="flex h-full w-full flex-1 flex-col gap-10 mt-6">

        <!-- 📊 Estadísticas -->
        <div class="grid gap-6 md:grid-cols-3">
            
            <!-- Tarjeta -->
            <div class="bg-white dark:bg-neutral-900/60 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm hover:shadow-md transition">
                <p class="text-neutral-500 text-sm">Reservas Hoy</p>
                <p class="text-4xl font-bold text-amber-600 mt-2">{{ $stats['reservations_today'] }}</p>
            </div>

            <div class="bg-white dark:bg-neutral-900/60 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm hover:shadow-md transition">
                <p class="text-neutral-500 text-sm">Próximas Reservas</p>
                <p class="text-4xl font-bold text-blue-600 mt-2">{{ $upcomingReservations->count() }}</p>
            </div>

            <div class="bg-white dark:bg-neutral-900/60 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm hover:shadow-md transition">
                <p class="text-neutral-500 text-sm">Mesas Ocupadas</p>
                <p class="text-4xl font-bold text-red-500 mt-2">{{ $stats['tables_occupied'] }}</p>
            </div>

        </div>

        <!-- 🎯 Acciones rápidas -->
        <div class="grid gap-6 md:grid-cols-2">

            <a href="{{ route('reservations.create') }}"
               class="flex items-center gap-4 p-6 bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-700 rounded-2xl shadow-sm hover:shadow-md hover:border-amber-500 transition">
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                    ➕
                </div>
                <div>
                    <p class="font-semibold">Nueva Reserva</p>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Registrar una nueva reserva</p>
                </div>
            </a>

            <a href="{{ route('tables.map') }}"
               class="flex items-center gap-4 p-6 bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-700 rounded-2xl shadow-sm hover:shadow-md hover:border-green-500 transition">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                    🗺️
                </div>
                <div>
                    <p class="font-semibold">Mapa de Mesas</p>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Disponibilidad en tiempo real</p>
                </div>
            </a>

        </div>

        <!-- 🕒 Reservas Pendientes -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
                Reservas Pendientes
                <span class="text-sm px-3 py-1 rounded-full bg-amber-200 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                    {{ $pendingReservations->count() }}
                </span>
            </h3>

            <div class="space-y-4 max-h-80 overflow-y-auto pr-2">

                @forelse ($pendingReservations as $reservation)
                    <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition">
                        <div>
                            <p class="font-semibold">{{ $reservation->client_name }}</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                {{ $reservation->people_count }} personas
                            </p>
                            <p class="text-xs text-neutral-500">
                                {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('d M - H:i') }}
                            </p>
                        </div>
                        <a href="{{ route('tables.assign', $reservation->id) }}"
                           class="px-4 py-2 bg-amber-500 text-white rounded-xl hover:bg-amber-600 transition">
                            Asignar Mesa
                        </a>
                    </div>
                @empty
                    <p class="text-center text-neutral-400 py-6">No hay reservas pendientes</p>
                @endforelse

            </div>
        </div>

        <!-- 📅 Próximas Reservas Confirmadas -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-6">Próximas Reservas Confirmadas</h3>

            <div class="space-y-4 max-h-80 overflow-y-auto pr-2">

                @forelse ($upcomingReservations as $reservation)
                    <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition">
                        <div>
                            <p class="font-medium">{{ $reservation->client_name }}</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ $reservation->people_count }} personas</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('d M') }}</p>
                            <p class="text-xs text-neutral-500">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-neutral-400 py-6">No hay reservas próximas</p>
                @endforelse

            </div>
        </div>

        <!-- 🍽️ Órdenes Activas -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-6">Órdenes Activas</h3>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($activeOrders as $order)
                    <div class="p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold">Mesa {{ $order->table->number }}</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ $order->orderItems->count() }} items
                        </p>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-neutral-400 py-6">No hay órdenes activas</p>
                @endforelse
            </div>
        </div>

    </div>

</x-layouts.app>
