<x-layouts.app :title="__('Órdenes')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Órdenes</h1>
                <p class="text-neutral-600 dark:text-neutral-400 mt-1">Gestiona todas las órdenes del restaurante</p>
            </div>
            <a href="{{ route('orders.create') }}" 
               class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nueva Orden
            </a>
        </div>

        <!-- Filtros -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <form method="GET" action="{{ route('orders.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium mb-2">Estado</label>
                    <select name="status" class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="all">Todos los estados</option>
                        <option value="En Vista" {{ request('status') === 'En Vista' ? 'selected' : '' }}>En Vista</option>
                        <option value="Confirmada" {{ request('status') === 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                        <option value="En Preparación" {{ request('status') === 'En Preparación' ? 'selected' : '' }}>En Preparación</option>
                        <option value="Lista" {{ request('status') === 'Lista' ? 'selected' : '' }}>Lista</option>
                        <option value="Entregada" {{ request('status') === 'Entregada' ? 'selected' : '' }}>Entregada</option>
                        <option value="Pagada" {{ request('status') === 'Pagada' ? 'selected' : '' }}>Pagada</option>
                    </select>
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium mb-2">Tipo</label>
                    <select name="type" class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="all">Todos los tipos</option>
                        <option value="Normal" {{ request('type') === 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Extra" {{ request('type') === 'Extra' ? 'selected' : '' }}>Extra</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                        Filtrar
                    </button>
                    <a href="{{ route('orders.index') }}" class="px-6 py-2 bg-neutral-200 hover:bg-neutral-300 dark:bg-neutral-700 dark:hover:bg-neutral-600 rounded-lg font-medium transition">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Lista de Órdenes -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-neutral-50 dark:bg-neutral-900/50 border-b border-neutral-200 dark:border-neutral-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Mesa</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Cliente</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Mesero</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Items</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Estado</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Tipo</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Fecha</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse($orders as $order)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-sm">#{{ $order->order_id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $order->table->number }}</span>
                                        </div>
                                        <span class="text-sm">Mesa {{ $order->table->number }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($order->customer)
                                        <div>
                                            <p class="font-medium text-sm">{{ $order->customer->name }}</p>
                                            @if($order->customer->phone)
                                                <p class="text-xs text-neutral-500">{{ $order->customer->phone }}</p>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-sm text-neutral-400">Sin cliente</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm">{{ $order->waiter->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium">{{ $order->orderItems->count() }} items</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-medium rounded-full
                                        @if($order->status === 'En Vista') bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200
                                        @elseif($order->status === 'Confirmada') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200
                                        @elseif($order->status === 'En Preparación') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                                        @elseif($order->status === 'Lista') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                                        @elseif($order->status === 'Entregada') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200
                                        @elseif($order->status === 'Pagada') bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-200
                                        @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2 py-1 text-xs rounded-full
                                        @if($order->type === 'Normal') bg-neutral-100 text-neutral-700 dark:bg-neutral-700 dark:text-neutral-300
                                        @else bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300
                                        @endif">
                                        {{ $order->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <p>{{ $order->created_at->format('d/m/Y') }}</p>
                                        <p class="text-xs text-neutral-500">{{ $order->created_at->format('H:i') }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('orders.show', $order->order_id) }}" 
                                           class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition"
                                           title="Ver detalles">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        
                                        @if(in_array($order->status, ['En Vista', 'Confirmada']))
                                            <a href="{{ route('orders.edit', $order->order_id) }}" 
                                               class="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-lg transition"
                                               title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        @endif

                                        @if($order->status === 'En Vista')
                                            <form action="{{ route('orders.destroy', $order->order_id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar esta orden?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition"
                                                        title="Eliminar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 text-neutral-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-neutral-600 dark:text-neutral-400 mb-4">No hay órdenes registradas</p>
                                    <a href="{{ route('orders.create') }}" class="inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                                        Crear Primera Orden
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </div>
</x-layouts.app>