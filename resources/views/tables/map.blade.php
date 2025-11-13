<x-layouts.app :title="__('Mapa de Mesas')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">Mapa de Mesas</h2>
                <div class="flex gap-2">
                    <a href="{{ route('tables.index') }}" 
                        class="bg-gray-500 hover:bg-gray-600 text-white rounded-lg px-4 py-2">
                        Ver Lista
                    </a>
                    <button onclick="location.reload()" 
                        class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg px-4 py-2">
                        Actualizar
                    </button>
                </div>
            </div>

            <!-- Leyenda -->
            <div class="mb-6 flex flex-wrap gap-4 p-4 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
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

            <!-- Grid de Mesas -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($tables as $table)
                    @php
                        $statusColors = [
                            'Disponible' => 'bg-green-500 hover:bg-green-600',
                            'Ocupada' => 'bg-red-500 hover:bg-red-600',
                            'Reservada' => 'bg-yellow-500 hover:bg-yellow-600',
                            'Necesita Limpieza' => 'bg-gray-500 hover:bg-gray-600',
                        ];
                        $color = $statusColors[$table->status] ?? 'bg-gray-500';
                    @endphp
                    
                    <div class="relative">
                        <div class="bg-white dark:bg-neutral-800 border-2 rounded-lg p-4 text-center transition-transform hover:scale-105 
                            @if($table->status === 'Disponible') border-green-500
                            @elseif($table->status === 'Ocupada') border-red-500
                            @elseif($table->status === 'Reservada') border-yellow-500
                            @else border-gray-500
                            @endif">
                            
                            <!-- Número de Mesa -->
                            <div class="text-3xl font-bold mb-2">Mesa {{ $table->number }}</div>
                            
                            <!-- Estado -->
                            <div class="text-sm font-medium mb-2">
                                <span class="px-2 py-1 rounded text-white {{ $color }}">
                                    {{ $table->status }}
                                </span>
                            </div>
                            
                            <!-- Capacidad -->
                            <div class="text-xs text-neutral-600 dark:text-neutral-400 mb-2">
                                Capacidad: {{ $table->capacity }} personas
                            </div>

                            <!-- Órdenes Activas -->
                            @if($table->orders->isNotEmpty())
                                <div class="mt-3 pt-3 border-t border-neutral-200 dark:border-neutral-700">
                                    <div class="text-xs font-semibold mb-2">Órdenes Activas:</div>
                                    @foreach($table->orders->take(2) as $order)
                                        <div class="text-xs mb-1 p-2 bg-neutral-50 dark:bg-neutral-700 rounded">
                                            <div class="font-medium">Orden #{{ $order->order_id }}</div>
                                            <div class="text-neutral-600 dark:text-neutral-400">
                                                {{ $order->waiter->name ?? 'Sin mesero' }}
                                            </div>
                                            <div class="text-xs mt-1">
                                                <span class="px-1 py-0.5 rounded text-white
                                                    @if($order->status === 'En Vista') bg-gray-500
                                                    @elseif($order->status === 'Confirmada') bg-blue-500
                                                    @elseif($order->status === 'En Preparación') bg-yellow-500
                                                    @elseif($order->status === 'Lista') bg-green-500
                                                    @endif">
                                                    {{ $order->status }}
                                                </span>
                                            </div>
                                            <div class="text-xs mt-1">
                                                {{ $order->orderItems->count() }} items
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($table->orders->count() > 2)
                                        <div class="text-xs text-neutral-500 mt-1">
                                            +{{ $table->orders->count() - 2 }} más
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Acciones -->
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('tables.show', $table->table_id) }}" 
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded px-2 py-1 text-center">
                                    Ver
                                </a>
                                @if($table->status === 'Disponible')
                                    <a href="{{ route('orders.create') }}?table_id={{ $table->table_id }}" 
                                        class="flex-1 bg-green-500 hover:bg-green-600 text-white text-xs rounded px-2 py-1 text-center">
                                        Orden
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($tables->isEmpty())
                <div class="text-center py-12">
                    <p class="text-neutral-600 dark:text-neutral-400">No hay mesas registradas</p>
                    <a href="{{ route('tables.create') }}" class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg px-6 py-2">
                        Crear Primera Mesa
                    </a>
                </div>
            @endif
        </div>

    </div>

    <!-- Auto-refresh cada 30 segundos -->
    <script>
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</x-layouts.app>

