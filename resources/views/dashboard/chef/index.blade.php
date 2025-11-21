<x-layouts.app :title="__('Dashboard Chef')">

    <!-- HERO Superior -->
    <section class="relative w-full rounded-2xl overflow-hidden shadow-lg">
        <img src="{{ asset('images/Restaurante.jpg') }}"
             class="absolute inset-0 w-full h-full object-cover brightness-[0.45]">
        <div class="relative z-10 p-10 text-white">
            <h2 class="text-4xl font-serif font-bold">👨‍🍳 ¡Hola, {{ auth()->user()->name }}!</h2>
            <p class="text-amber-300 text-lg">
                Tienes {{ $chefOrders->count() }} órdenes activas
            </p>

        </div>
    </section>

    <div class="flex h-full w-full flex-1 flex-col gap-10 mt-6">

        <!-- 📊 Estadísticas Rápidas -->
        <div class="grid gap-6 md:grid-cols-3">
            <div class="bg-white dark:bg-neutral-900/60 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm hover:shadow-md transition">
                <p class="text-neutral-500 text-sm">Órdenes en preparación</p>
                <p class="text-4xl font-bold text-blue-600 mt-2">{{ $stats['preparing_items'] }}</p>
            </div>

            <div class="bg-white dark:bg-neutral-900/60 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm hover:shadow-md transition">
                <p class="text-neutral-500 text-sm">Órdenes completadas hoy</p>
                <p class="text-4xl font-bold text-green-600 mt-2">{{ $stats['ready_today'] }}</p>
            </div>

            <div class="bg-white dark:bg-neutral-900/60 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm hover:shadow-md transition">
                <p class="text-neutral-500 text-sm">Órdenes pendientes</p>
                <p class="text-4xl font-bold text-amber-600 mt-2">{{ $stats['pending_items'] }}</p>
            </div>
        </div>

        <!-- Órdenes Activas en Cocina -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-6 flex items-center gap-2">
                Órdenes Activas
                <span class="text-sm px-3 py-1 rounded-full bg-blue-200 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                    {{ $chefOrders ->count() }}
                </span>
            </h3>

            <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                @forelse($chefOrders  as $order)
                    <div class="p-5 bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold">Mesa {{ $order->table->number }}</h4>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    Orden #{{ $order->id }} • {{ $order->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="inline-block px-4 py-2 text-sm font-medium rounded-full
                                {{ $order->status === 'en_proceso' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200' : '' }}">
                                {{ ucfirst(str_replace('_',' ',$order->status)) }}
                            </span>
                        </div>

                        <!-- Items de la orden -->
                        <div class="space-y-2 mb-4">
                            @foreach($order->orderItems as $item)
                                @php
                                    $subtotal = $item->quantity * $item->price;
                                @endphp
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium">{{ $item->quantity }}x</span>
                                        <span>{{ $item->product->name }}</span>
                                        <span class="text-xs text-neutral-500">(${{
                                            number_format($item->price,0,',','.')
                                        }})</span>
                                        <span class="text-xs text-neutral-500">Subtotal: ${{ number_format($subtotal,0,',','.') }}</span>
                                        @if($item->notes)
                                            <span class="text-xs text-neutral-400">({{ $item->notes }})</span>
                                        @endif
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{
                                            $item->status === 'pendiente' 
                                                ? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'
                                            : ($item->status === 'preparando'
                                                ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300'
                                            : ($item->status === 'listo'
                                                ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'
                                            : ($item->status === 'cancelado'
                                                ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300'
                                            : 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300')))
                                        }}">

                                        {{ ucfirst($item->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Acciones -->
                        <div class="flex gap-2">
                            <a href="{{ route('orders.show', $order->id) }}" 
                               class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-center rounded-xl transition text-sm font-medium">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-neutral-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-4">No hay órdenes activas en cocina</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</x-layouts.app>
