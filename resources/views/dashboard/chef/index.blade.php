<x-layouts.app :title="__('Dashboard Cocina')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <!-- Header de Cocina -->
        <div class="bg-gradient-to-r from-orange-500 to-red-600 dark:from-orange-700 dark:to-red-800 rounded-xl p-8 text-white">
            <h2 class="text-3xl font-bold mb-2">🔥 Cocina - Vista en Tiempo Real</h2>
            <p class="text-orange-100">{{ $kitchenOrders->count() }} órdenes en proceso</p>
        </div>

        <!-- Estadísticas de Cocina -->
        <div class="grid gap-4 md:grid-cols-4">
            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Pendientes</p>
                        <p class="text-3xl font-semibold mt-2">
                            {{ $kitchenOrders->sum(function($order) {
                                return $order->orderItems->where('status', 'Pendiente')->count();
                            }) }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">En Preparación</p>
                        <p class="text-3xl font-semibold mt-2">
                            {{ $kitchenOrders->sum(function($order) {
                                return $order->orderItems->where('status', 'En Preparación')->count();
                            }) }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Órdenes Activas</p>
                        <p class="text-3xl font-semibold mt-2">{{ $kitchenOrders->count() }}</p>
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
        </div>

        <!-- Órdenes en Cocina -->
        <div class="grid gap-6 lg:grid-cols-2">
            @forelse($kitchenOrders as $order)
                <div class="bg-white dark:bg-neutral-800 rounded-xl border-2 
                    @if($order->status === 'Confirmada') border-blue-300 dark:border-blue-700
                    @else border-yellow-300 dark:border-yellow-700
                    @endif p-6">
                    
                    <!-- Header de la Orden -->
                    <div class="flex items-start justify-between mb-4 pb-4 border-b border-neutral-200 dark:border-neutral-700">
                        <div>
                            <h3 class="text-2xl font-bold">Mesa {{ $order->table->number }}</h3>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                Orden #{{ $order->order_id }}
                            </p>
                            <p class="text-xs text-neutral-500 mt-1">
                                {{ $order->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 text-sm font-medium rounded-full
                                @if($order->status === 'Confirmada') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                                @endif">
                                {{ $order->status }}
                            </span>
                            @if($order->type === 'Extra')
                                <span class="block mt-2 text-xs px-2 py-1 bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200 rounded-full inline-block">
                                    URGENTE
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Items de la Orden -->
                    <div class="space-y-3 mb-4">
                        @foreach($order->orderItems as $item)
                            <div class="p-3 rounded-lg 
                                @if($item->status === 'Pendiente') bg-gray-50 dark:bg-gray-900/50
                                @elseif($item->status === 'En Preparación') bg-yellow-50 dark:bg-yellow-900/20
                                @else bg-green-50 dark:bg-green-900/20
                                @endif">
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl font-bold">{{ $item->quantity }}x</span>
                                            <div>
                                                <p class="font-semibold">{{ $item->product->name }}</p>
                                                @if($item->notes)
                                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                                                        📝 {{ $item->notes }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Botones de Estado -->
                                    <div class="flex gap-2">
                                        @if($item->status === 'Pendiente')
                                            <form action="{{ route('orders.items.updateStatus', $item->order_item_id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="En Preparación">
                                                <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-medium transition">
                                                    Iniciar
                                                </button>
                                            </form>
                                        @elseif($item->status === 'En Preparación')
                                            <form action="{{ route('orders.items.updateStatus', $item->order_item_id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="Listo">
                                                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium transition">
                                                    ✓ Listo
                                                </button>
                                            </form>
                                        @else
                                            <span class="px-4 py-2 bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200 rounded-lg text-sm font-medium">
                                                ✓ Completado
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Progreso de la Orden -->
                    <div class="pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        @php
                            $totalItems = $order->orderItems->count();
                            $readyItems = $order->orderItems->where('status', 'Listo')->count();
                            $progress = $totalItems > 0 ? ($readyItems / $totalItems) * 100 : 0;
                        @endphp
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium">Progreso</span>
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ $readyItems }}/{{ $totalItems }} items</span>
                        </div>
                        <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-500" 
                                 style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-2 text-center py-16">
                    <svg class="w-24 h-24 text-neutral-300 dark:text-neutral-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">¡Todo al día! 🎉</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">No hay órdenes pendientes en este momento</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Auto-refresh cada 30 segundos -->
    <script>
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</x-layouts.app>

