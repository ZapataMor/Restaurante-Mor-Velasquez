<x-layouts.app :title="__('Detalle de Orden')">

    <!-- HERO superior -->
    <section class="relative w-full rounded-2xl overflow-hidden shadow-lg mb-6">
        <img src="{{ asset('images/Restaurante.jpg') }}"
             class="absolute inset-0 w-full h-full object-cover brightness-[0.45]">
        <div class="relative z-10 p-10 text-white">
            <h2 class="text-4xl font-serif font-bold">📝 Orden #{{ $order->id }}</h2>
            <p class="text-amber-300 text-lg">
                Mesa {{ $order->table->number }} • Mesero: {{ $order->user->name ?? 'Sin asignar' }}
            </p>
        </div>
    </section>

    <div class="flex flex-col gap-6">

        <!-- Información general -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-4">Información de la Orden</h3>

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <p class="text-sm text-neutral-500">Estado</p>
                    <span class="inline-block mt-1 px-3 py-1 text-xs rounded-full text-white
                        @if($order->status === 'abierta') bg-gray-500
                        @elseif($order->status === 'en_proceso') bg-blue-500
                        @elseif($order->status === 'completada') bg-green-500
                        @elseif($order->status === 'cancelada') bg-red-500
                        @endif">
                        {{ ucfirst(str_replace('_',' ',$order->status)) }}
                    </span>
                </div>

                <div>
                    <p class="text-sm text-neutral-500">Cliente</p>
                    <p class="mt-1 text-neutral-700 dark:text-neutral-200">
                        {{ $order->client_name ?? 'Sin asignar' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-neutral-500">Fecha / Hora</p>
                    <p class="mt-1 text-neutral-700 dark:text-neutral-200">
                        {{ $order->created_at->format('d M Y - H:i') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Items de la Orden -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-4">Items de la Orden</h3>

            @forelse($order->orderItems as $item)
                <div class="flex items-center justify-between p-4 mb-2 bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <div class="flex flex-col">
                        <p class="font-medium">{{ $item->quantity }}x {{ $item->product->name }}</p>
                        @if($item->notes)
                            <p class="text-xs text-neutral-500 mt-1">Notas: {{ $item->notes }}</p>
                        @endif
                    </div>

                    <span class="px-2 py-1 text-xs rounded-full text-white
                        @if($item->status === 'Pendiente') bg-gray-500
                        @elseif($item->status === 'En Preparación') bg-yellow-500
                        @elseif($item->status === 'Listo') bg-green-500
                        @endif">
                        {{ $item->status }}
                    </span>
                </div>
            @empty
                <p class="text-neutral-500 text-center py-6">No hay items en esta orden</p>
            @endforelse
        </div>

        <!-- Acciones -->
        <div class="flex flex-wrap gap-3">
            @if($order->status !== 'completada')
                <a href="{{ route('orders.edit', $order->id) }}"
                   class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-center text-sm transition">
                   Editar Orden
                </a>
            @endif

            @if($order->status !== 'completada')
                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="completada">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm transition">
                        Marcar como Completada
                    </button>
                </form>
            @endif

            <a href="{{ route('tables.map') }}"
               class="flex-1 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-xl text-center text-sm transition">
               Volver a Mesas
            </a>
        </div>

    </div>

</x-layouts.app>
