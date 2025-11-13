<x-layouts.app :title="__('Dashboard Administrador')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <!-- Estadísticas Principales -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
            <!-- Órdenes Hoy -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Órdenes Hoy</p>
                        <p class="text-3xl font-semibold mt-2">{{ $stats['orders_today'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Ventas Hoy -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Ventas Hoy</p>
                        <p class="text-3xl font-semibold mt-2">${{ number_format($stats['sales_today'], 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Reservas Hoy -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Reservas Hoy</p>
                        <p class="text-3xl font-semibold mt-2">{{ $stats['reservations_today'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Mesas Ocupadas -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Mesas Ocupadas</p>
                        <p class="text-3xl font-semibold mt-2">{{ $stats['tables_occupied'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stock Bajo -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Stock Bajo</p>
                        <p class="text-3xl font-semibold mt-2">{{ $stats['low_stock_ingredients'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Ventas y Órdenes Activas -->
        <div class="grid gap-6 lg:grid-cols-2">
            
            <!-- Ventas Últimos 7 Días -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="text-lg font-semibold mb-4">Ventas - Últimos 7 Días</h3>
                <div class="space-y-3">
                    @forelse($salesByDay as $sale)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm">{{ \Carbon\Carbon::parse($sale->date)->format('d M') }}</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ $sale->count }} órdenes</span>
                                <span class="font-semibold">${{ number_format($sale->total, 2) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500 text-center py-4">No hay datos disponibles</p>
                    @endforelse
                </div>
            </div>

            <!-- Órdenes Activas -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="text-lg font-semibold mb-4">Órdenes Activas</h3>
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @forelse($activeOrders as $order)
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
                            <div>
                                <p class="font-medium">Mesa {{ $order->table->number }}</p>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ $order->orderItems->count() }} items • {{ $order->waiter->name }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 text-xs font-medium rounded-full
                                    @if($order->status === 'En Vista') bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200
                                    @elseif($order->status === 'Confirmada') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200
                                    @elseif($order->status === 'En Preparación') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                                    @elseif($order->status === 'Lista') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                                    @endif">
                                    {{ $order->status }}
                                </span>
                                <p class="text-xs text-neutral-500 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500 text-center py-8">No hay órdenes activas</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Productos Más Vendidos y Reservas Próximas -->
        <div class="grid gap-6 lg:grid-cols-2">
            
            <!-- Top 5 Productos -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="text-lg font-semibold mb-4">Top 5 Productos (30 días)</h3>
                <div class="space-y-4">
                    @forelse($topProducts as $product)
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <p class="font-medium">{{ $product->name }}</p>
                                <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 mt-2">
                                    <div class="bg-amber-500 h-2 rounded-full" style="width: {{ ($product->total_sold / $topProducts->max('total_sold')) * 100 }}%"></div>
                                </div>
                            </div>
                            <span class="font-semibold text-lg">{{ $product->total_sold }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500 text-center py-4">No hay datos disponibles</p>
                    @endforelse
                </div>
            </div>

            <!-- Próximas Reservas -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="text-lg font-semibold mb-4">Próximas Reservas</h3>
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @forelse($upcomingReservations as $reservation)
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
                            <div>
                                <p class="font-medium">{{ $reservation->customer->name }}</p>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    Mesa {{ $reservation->table->number }} • {{ $reservation->number_of_people }} personas
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M') }}</p>
                                <p class="text-xs text-neutral-500">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500 text-center py-8">No hay reservas próximas</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Ingredientes con Stock Bajo -->
        @if($lowStockIngredients->isNotEmpty())
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">⚠️ Ingredientes con Stock Bajo</h3>
                <a href="{{ route('ingredients.index') }}" class="text-sm text-amber-600 hover:text-amber-700">Ver todos</a>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($lowStockIngredients as $ingredient)
                    <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                        <p class="font-medium text-sm">{{ $ingredient->name }}</p>
                        <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-1">
                            Stock: {{ $ingredient->current_stock }} {{ $ingredient->unit_measure }}
                        </p>
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">
                            Mínimo: {{ $ingredient->reorder_point }} {{ $ingredient->unit_measure }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</x-layouts.app>

