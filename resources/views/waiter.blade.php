<x-layouts.app :title="__('Dashboard Mesero')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <!-- Bienvenida -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-700 dark:to-blue-800 rounded-xl p-8 text-white">
            <h2 class="text-3xl font-bold mb-2">¡Hola, {{ auth()->user()->name }}!</h2>
            <p class="text-blue-100">Tienes {{ $myOrders->count() }} órdenes activas en este momento</p>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="grid gap-4 md:grid-cols-3">
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Mis Órdenes Activas</p>
                        <p class="text-3xl font-semibold mt-2">{{ $myOrders->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Órdenes Hoy</p>
                        <p class="text-3xl font-semibold mt-2">{{ $stats['orders_today'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

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
        </div>

        <!-- Acciones Rápidas -->
        <div class="grid gap-4 md:grid-cols-2">
            <a href="{{ route('orders.create') }}" class="flex items-center gap-4 p-6 bg-white dark:bg-neutral-800 rounded-xl border-2 border-dashed border-neutral-300 dark:border-neutral-600 hover:border-blue-500 dark:hover:border-blue-500 transition-colors">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Nueva Orden</p>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Crear una nueva orden para una mesa</p>
                </div>
            </a>

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

        <!-- Mis Órdenes Activas -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h3 class="text-xl font-semibold mb-6">Mis Órdenes Activas</h3>
            
            @forelse($myOrders as $order)
                <div class="mb-4 p-5 bg-neutral-50 dark:bg-neutral-700/50 rounded-xl border border-neutral-200 dark:border-neutral-600">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h4 class="text-lg font-semibold">Mesa {{ $order->table->number }}</h4>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                Orden #{{ $order->order_id }} • {{ $order->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <span class="inline-block px-4 py-2 text-sm font-medium rounded-full
                            @if($order->status === 'En Vista') bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200
                            @elseif($order->status === 'Confirmada') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200
                            @elseif($order->status === 'En Preparación') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                            @elseif($order->status === 'Lista') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                            @elseif($order->status === 'Entregada') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200
                            @endif">
                            {{ $order->status }}
                        </span>
                    </div>

                    <!-- Items de la orden -->
                    <div class="space-y-2 mb-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium">{{ $item->quantity }}x</span>
                                    <span>{{ $item->product->name }}</span>
                                    @if($item->notes)
                                        <span class="text-xs text-neutral-500">({{ $item->notes }})</span>
                                    @endif
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($item->status === 'Pendiente') bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                                    @elseif($item->status === 'En Preparación') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300
                                    @elseif($item->status === 'Listo') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300
                                    @endif">
                                    {{ $item->status }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Acciones -->
                    <div class="flex gap-2">
                        <a href="{{ route('orders.show', $order->order_id) }}" 
                           class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-center rounded-lg transition text-sm font-medium">
                            Ver Detalles
                        </a>
                        @if($order->status === 'En Vista')
                            <form action="{{ route('orders.updateStatus', $order->order_id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Confirmada">
                                <button type="submit" class="w-full px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition text-sm font-medium">
                                    Confirmar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-neutral-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-neutral-600 dark:text-neutral-400">No tienes órdenes activas en este momento</p>
                    <a href="{{ route('orders.create') }}" class="inline-block mt-4 px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                        Crear Nueva Orden
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Todas las Órdenes Activas del Restaurante -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h3 class="text-xl font-semibold mb-6">Todas las Órdenes Activas</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($activeOrders->take(6) as $order)
                    <div class="p-4 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg border border-neutral-200 dark:border-neutral-600">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold">Mesa {{ $order->table->number }}</span>
                            <span class="text-xs px-2 py-1 rounded-full
                                @if($order->status === 'En Vista') bg-gray-100 text-gray-700
                                @elseif($order->status === 'Confirmada') bg-blue-100 text-blue-700
                                @elseif($order->status === 'En Preparación') bg-yellow-100 text-yellow-700
                                @elseif($order->status === 'Lista') bg-green-100 text-green-700
                                @endif">
                                {{ $order->status }}
                            </span>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ $order->orderItems->count() }} items
                        </p>
                        <p class="text-xs text-neutral-500 mt-1">{{ $order->waiter->name }}</p>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-neutral-500 py-8">No hay más órdenes activas</p>
                @endforelse
            </div>
        </div>

    </div>
</x-layouts.app>