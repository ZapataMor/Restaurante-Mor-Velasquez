<x-layouts.app :title="__('Dashboard Administrador')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 sm:gap-6">
        <!-- Estadísticas Principales -->
        <div class="grid gap-3 sm:gap-4 grid-cols-2 lg:grid-cols-4">

            <!-- Órdenes Hoy -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 truncate">Órdenes Hoy</p>
                        <p class="text-2xl sm:text-3xl font-semibold mt-1 sm:mt-2">{{ $stats['orders_today'] }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">+12% vs ayer</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Ventas Hoy -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 truncate">Ventas Hoy</p>
                        <p class="text-xl sm:text-3xl font-semibold mt-1 sm:mt-2">${{ number_format($stats['sales_today'], 0) }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">+8% vs ayer</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Reservas Hoy -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 truncate">Reservas Hoy</p>
                        <p class="text-2xl sm:text-3xl font-semibold mt-1 sm:mt-2">{{ $stats['reservations_today'] }}</p>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">{{ $stats['pending_reservations'] ?? 0 }} pendientes</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Mesas Ocupadas -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 truncate">Mesas Ocupadas</p>
                        <p class="text-2xl sm:text-3xl font-semibold mt-1 sm:mt-2">{{ $stats['tables_occupied'] }}/{{ $stats['total_tables'] ?? 20 }}</p>
                        <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">{{ round(($stats['tables_occupied'] / ($stats['total_tables'] ?? 20)) * 100) }}% ocupación</p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center flex-shrink-0 ml-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('tables.map') }}" class="flex items-center gap-4 p-6 bg-white dark:bg-neutral-800 rounded-xl border-2 border-dashed border-neutral-300 dark:border-neutral-600 hover:border-green-500 dark:hover:border-green-500 transition-colors">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Ver Mapa de Mesas</p>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Estado actual del restaurante</p>
                </div>
            </a>

        </div>

        <!-- Gestión de Personal y Órdenes Activas -->
        <div class="grid gap-4 sm:gap-6 lg:grid-cols-3">
            
            <!-- Personal Activo -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base sm:text-lg font-semibold">Personal en Turno</h3>
                    {{-- <flux:button href="{{ route('admin.users.index') }}" size="sm" variant="ghost">
                        Ver todos
                    </flux:button> --}}
                </div>
                <div class="space-y-3 max-h-72 overflow-y-auto">
                    @forelse($activeStaff ?? [] as $staff)
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold flex-shrink-0">
                                    {{ substr($staff->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-sm truncate">{{ $staff->name ?? 'Usuario' }}</p>
                                    <p class="text-xs text-neutral-600 dark:text-neutral-400 truncate">
                                        {{ $staff->role ?? 'Mesero' }} • {{ $staff->orders_count ?? 0 }} órdenes
                                    </p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-2">
                                <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center text-neutral-500 py-8">No hay personal activo</p>
                    @endforelse
                </div>
            </div>

            <!-- Órdenes Activas -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base sm:text-lg font-semibold">Órdenes Activas</h3>
                    {{-- <flux:button href="{{ route('admin.orders.index') }}" size="sm" variant="ghost">
                        Ver todas
                    </flux:button> --}}
                </div>
                <div class="space-y-3 max-h-72 overflow-y-auto">
                    @forelse($activeOrders as $order)
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-3 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center font-semibold text-blue-600 dark:text-blue-400 flex-shrink-0">
                                    {{ $order->table->number ?? '0' }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-sm">Mesa {{ $order->table->number ?? '0' }}</p>
                                    <p class="text-xs text-neutral-600 dark:text-neutral-400 truncate">
                                        {{ $order->orderItems->count() }} items • {{ $order->waiter->name ?? 'Sin asignar' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 sm:flex-col sm:items-end">
                                <span class="inline-block px-2 sm:px-3 py-1 text-xs font-medium rounded-full whitespace-nowrap
                                    @if($order->status === 'En Vista') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                    @elseif($order->status === 'Confirmada') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                    @elseif($order->status === 'En Preparación') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                    @elseif($order->status === 'Lista') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                    @endif">
                                    {{ $order->status }}
                                </span>
                                <p class="text-xs text-neutral-500 whitespace-nowrap">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center text-neutral-500 py-8">No hay órdenes activas</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Análisis y Estadísticas -->
        <div class="grid gap-4 sm:gap-6 lg:grid-cols-2">
            
            <!-- Ventas Últimos 7 Días -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base sm:text-lg font-semibold">Ventas - Últimos 7 Días</h3>
                    {{-- <flux:button href="{{ route('admin.reports.sales') }}" size="sm" variant="ghost">
                        Detalle
                    </flux:button> --}}
                </div>
                <div class="space-y-3">
                    @forelse($salesByDay as $sale)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></div>
                                <span class="text-sm truncate">{{ \Carbon\Carbon::parse($sale->date)->format('d M') }}</span>
                            </div>
                            <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
                                <span class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400">{{ $sale->count }} órdenes</span>
                                <span class="font-semibold text-sm sm:text-base">${{ number_format($sale->total, 0) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center text-neutral-500 py-4">Sin datos</p>
                    @endforelse
                </div>
                
                <!-- Promedio -->
                <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-600 dark:text-neutral-400">Promedio diario</span>
                        <span class="font-semibold">${{ number_format($salesByDay->avg('total') ?? 0, 0) }}</span>
                    </div>
                </div>
            </div>

            <!-- Top 5 Productos -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base sm:text-lg font-semibold">Top 5 Productos (30 días)</h3>
                    {{-- <flux:button href="{{ route('admin.reports.products') }}" size="sm" variant="ghost">
                        Ver todos
                    </flux:button> --}}
                </div>
                <div class="space-y-4">
                    @forelse($topProducts as $index => $product)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-sm truncate">{{ $product->name }}</p>
                                <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 mt-2">
                                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 h-2 rounded-full transition-all duration-500"
                                         style="width: {{ ($product->total_sold / $topProducts->max('total_sold')) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                            <span class="font-semibold text-base sm:text-lg flex-shrink-0">{{ $product->total_sold }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-center py-4 text-neutral-500">No hay productos vendidos</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Reservas y Rendimiento del Personal -->
        <div class="grid gap-4 sm:gap-6 lg:grid-cols-2">

            <!-- Próximas Reservas -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base sm:text-lg font-semibold">Próximas Reservas</h3>
                    {{-- <flux:button href="{{ route('admin.reservations.index') }}" size="sm" variant="ghost">
                        Gestionar
                    </flux:button> --}}
                </div>
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @forelse($upcomingReservations as $reservation)
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-3 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                    {{ $reservation->people_count }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-sm truncate">{{ $reservation->client_name }}</p>
                                    <p class="text-xs text-neutral-600 dark:text-neutral-400 truncate">
                                        {{ $reservation->people_count }} personas • {{ $reservation->client_contact }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 sm:flex-col sm:items-end flex-shrink-0">
                                <p class="text-sm font-medium whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('d M') }}
                                </p>
                                <p class="text-xs text-neutral-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center py-8 text-neutral-500">No hay reservas próximas</p>
                    @endforelse
                </div>
            </div>

            <!-- Rendimiento del Personal -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base sm:text-lg font-semibold">Rendimiento Personal (Hoy)</h3>
                    {{-- <flux:button href="{{ route('admin.reports.staff') }}" size="sm" variant="ghost">
                        Reportes
                    </flux:button> --}}
                </div>
                <div class="space-y-3">
                    @forelse($staffPerformance ?? [] as $staff)
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white font-semibold flex-shrink-0">
                                    {{ substr($staff->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-sm truncate">{{ $staff->name ?? 'Usuario' }}</p>
                                    <p class="text-xs text-neutral-600 dark:text-neutral-400">
                                        {{ $staff->orders_today ?? 0 }} órdenes • ${{ number_format($staff->sales_today ?? 0, 0) }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1 flex-shrink-0">
                                <span class="text-sm font-semibold">${{ number_format($staff->average_ticket ?? 0, 0) }}</span>
                                <span class="text-xs text-neutral-500">ticket prom.</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center py-8 text-neutral-500">Sin datos de rendimiento</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</x-layouts.app>