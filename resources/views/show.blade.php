<x-layouts.app :title="__('Orden #' . $order->order_id)">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-bold">Orden #{{ $order->order_id }}</h1>
                    <span class="px-4 py-2 text-sm font-medium rounded-full
                        @if($order->status === 'En Vista') bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200
                        @elseif($order->status === 'Confirmada') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200
                        @elseif($order->status === 'En Preparación') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                        @elseif($order->status === 'Lista') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                        @elseif($order->status === 'Entregada') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200
                        @elseif($order->status === 'Pagada') bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-200
                        @endif">
                        {{ $order->status }}
                    </span>
                    @if($order->type === 'Extra')
                        <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200 rounded-full">
                            URGENTE
                        </span>
                    @endif
                </div>
                <p class="text-neutral-600 dark:text-neutral-400 mt-1">
                    Creada el {{ $order->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('orders.index') }}" 
                   class="px-6 py-3 bg-neutral-200 hover:bg-neutral-300 dark:bg-neutral-700 dark:hover:bg-neutral-600 rounded-lg font-medium transition">
                    Volver
                </a>
                @if(in_array($order->status, ['En Vista', 'Confirmada']))
                    <a href="{{ route('orders.edit', $order->order_id) }}" 
                       class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-medium transition">
                        Editar
                    </a>
                @endif
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            
            <!-- Información de la Orden -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Detalles Generales -->
                <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                    <h3 class="text-lg font-semibold mb-4">Información General</h3>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Mesa</label>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                    <span class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $order->table->number }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold">Mesa {{ $order->table->number }}</p>
                                    <p class="text-sm text-neutral-500">Capacidad: {{ $order->table->capacity }} personas</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Mesero</label>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                    <span class="text-xl font-bold text-purple-600 dark:text-purple-400">
                                        {{ substr($order->waiter->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $order->waiter->name }}</p>
                                    <p class="text-sm text-neutral-500">{{ $order->waiter->email }}</p>
                                </div>
                            </div>
                        </div>

                        @if($order->customer)
                            <div>
                                <label class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Cliente</label>
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $order->customer->name }}</p>
                                        @if($order->customer->phone)
                                            <p class="text-sm text-neutral-500">{{ $order->customer->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Tipo de Orden</label>
                            <span class="inline-block px-3 py-2 text-sm rounded-lg
                                @if($order->type === 'Normal') bg-neutral-100 dark:bg-neutral-700
                                @else bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300
                                @endif">
                                {{ $order->type }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Items de la Orden -->
                <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                    <h3 class="text-lg font-semibold mb-4">Items de la Orden</h3>
                    
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="p-4 border border-neutral-200 dark:border-neutral-700 rounded-lg">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $item->quantity }}x</span>
                                            <div>
                                                <h4 class="font-semibold">{{ $item->product->name }}</h4>
                                                <p class="text-sm text-neutral-500">${{ number_format($item->product->price, 2) }} c/u</p>
                                            </div>
                                        </div>
                                        @if($item->notes)
                                            <div class="mt-2 p-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded">
                                                <p class="text-sm text-amber-800 dark:text-amber-200">
                                                    📝 {{ $item->notes }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full mb-2
                                            @if($item->status === 'Pendiente') bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200
                                            @elseif($item->status === 'En Preparación') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                                            @elseif($item->status === 'Listo') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                                            @endif">
                                            {{ $item->status }}
                                        </span>
                                        <p class="font-bold text-lg">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="mt-6 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <div class="flex items-center justify-between text-xl">
                            <span class="font-semibold">Total:</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400">
                                ${{ number_format($order->orderItems->sum(function($item) {
                                    return $item->product->price * $item->quantity;
                                }), 2) }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Panel Lateral de Acciones -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 sticky top-6">
                    <h3 class="text-lg font-semibold mb-4">Acciones</h3>
                    
                    <!-- Cambiar Estado -->
                    @if(!in_array($order->status, ['Pagada']))
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Cambiar Estado</label>
                            <form action="{{ route('orders.updateStatus', $order->order_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" 
                                        class="w-full px-4 py-2 mb-3 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="En Vista" {{ $order->status === 'En Vista' ? 'selected' : '' }}>En Vista</option>
                                    <option value="Confirmada" {{ $order->status === 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                                    <option value="En Preparación" {{ $order->status === 'En Preparación' ? 'selected' : '' }}>En Preparación</option>
                                    <option value="Lista" {{ $order->status === 'Lista' ? 'selected' : '' }}>Lista</option>
                                    <option value="Entregada" {{ $order->status === 'Entregada' ? 'selected' : '' }}>Entregada</option>
                                    <option value="Pagada" {{ $order->status === 'Pagada' ? 'selected' : '' }}>Pagada</option>
                                </select>
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                                    Actualizar Estado
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Línea de Tiempo del Estado -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium mb-3">Estado de la Orden</h4>
                        <div class="space-y-2">
                            @php
                                $statuses = ['En Vista', 'Confirmada', 'En Preparación', 'Lista', 'Entregada', 'Pagada'];
                                $currentIndex = array_search($order->status, $statuses);
                            @endphp
                            @foreach($statuses as $index => $status)
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full 
                                        @if($index <= $currentIndex) bg-green-500
                                        @else bg-neutral-300 dark:bg-neutral-700
                                        @endif">
                                    </div>
                                    <span class="text-sm 
                                        @if($index <= $currentIndex) font-medium
                                        @else text-neutral-500
                                        @endif">
                                        {{ $status }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Factura -->
                    @if($order->invoice)
                        <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg mb-4">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-semibold text-green-800 dark:text-green-200">Facturada</span>
                            </div>
                            <p class="text-sm text-green-700 dark:text-green-300">
                                Factura #{{ $order->invoice->invoice_id }}
                            </p>
                            <a href="{{ route('invoices.show', $order->invoice->invoice_id) }}" 
                               class="text-sm text-green-600 dark:text-green-400 hover:underline mt-2 inline-block">
                                Ver factura →
                            </a>
                        </div>
                    @else
                        <a href="{{ route('invoices.create', ['order_id' => $order->order_id]) }}" 
                           class="block w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-center rounded-lg font-medium transition mb-4">
                            Generar Factura
                        </a>
                    @endif

                    <!-- Información Adicional -->
                    <div class="p-4 bg-neutral-50 dark:bg-neutral-700/50 rounded-lg">
                        <h4 class="text-sm font-medium mb-2">Información Adicional</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">Items:</span>
                                <span class="font-medium">{{ $order->orderItems->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">Creada:</span>
                                <span class="font-medium">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">Actualizada:</span>
                                <span class="font-medium">{{ $order->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Eliminar -->
                    @if($order->status === 'En Vista')
                        <form action="{{ route('orders.destroy', $order->order_id) }}" method="POST" 
                              class="mt-6" onsubmit="return confirm('¿Estás seguro de eliminar esta orden?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition">
                                Eliminar Orden
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>