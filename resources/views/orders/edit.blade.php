<x-layouts.app :title="__('Editar Orden')">

    <!-- HERO superior -->
    <section class="relative w-full rounded-2xl overflow-hidden shadow-lg mb-6">
        <img src="{{ asset('images/Restaurante.jpg') }}"
             class="absolute inset-0 w-full h-full object-cover brightness-[0.45]">
        <div class="relative z-10 p-10 text-white">
            <h2 class="text-4xl font-serif font-bold">✏️ Editar Orden #{{ $order->id }}</h2>
            <p class="text-amber-300 text-lg">
                Mesa {{ $order->table->number }} • Mesero: {{ $order->user->name ?? 'Sin asignar' }}
            </p>
        </div>
    </section>

    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="flex flex-col gap-6">
        @csrf
        @method('PUT')

        <!-- Información general -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-4">Información de la Orden</h3>

            <input type="hidden" name="table_id" value="{{ $order->table_id }}">
            <input type="hidden" name="user_id" value="{{ $order->user_id }}">
            <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">


            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-sm text-neutral-500">Estado</label>
                    <select name="status" class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm p-2">
                        <option value="abierta" {{ $order->status === 'abierta' ? 'selected' : '' }}>Abierta</option>
                        <option value="en_proceso" {{ $order->status === 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="completada" {{ $order->status === 'completada' ? 'selected' : '' }}>Completada</option>
                        <option value="cancelada" {{ $order->status === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-neutral-500">Cliente</label>
                    <input type="text" name="client_name" value="{{ $order->client_name }}" 
                           class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-2 text-sm" />
                </div>

                <div>
                    <label class="text-sm text-neutral-500">Mesero</label>
                    <p class="mt-1 text-neutral-700 dark:text-neutral-200">{{ $order->user->name ?? 'Sin asignar' }}</p>
                </div>
            </div>
        </div>

        <!-- Items de la Orden -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-4">Items de la Orden</h3>

            @foreach($order->orderItems as $index => $item)
                <div class="flex flex-col md:flex-row md:items-center md:justify-between p-4 mb-2 bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 gap-2">
                    
                    <!-- Producto -->
                    <div class="flex-1">
                        <p class="font-medium text-sm">{{ $item->product->name }}</p>
                    </div>

                    <!-- Cantidad -->
                    <div class="w-20">
                        <label class="text-xs text-neutral-500">Cantidad</label>
                        <input type="number" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}" min="1" 
                               class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-1 text-sm" />
                    </div>

                    <!-- Notas -->
                    <div class="flex-1">
                        <label class="text-xs text-neutral-500">Notas</label>
                        <input type="text" name="items[{{ $item->id }}][notes]" value="{{ $item->notes }}" 
                               class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-1 text-sm" />
                    </div>

                    <!-- Estado -->
                    <div class="w-32">
                        <label class="text-xs text-neutral-500">Estado</label>
                        <select name="items[{{ $item->id }}][status]" 
                                class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm p-1">
                            <option value="Pendiente" {{ $item->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="En Preparación" {{ $item->status === 'preparando' ? 'selected' : '' }}>En Preparación</option>
                            <option value="Listo" {{ $item->status === 'Listo' ? 'selected' : '' }}>Listo</option>
                        </select>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Acciones -->
        <div class="flex flex-wrap gap-3">
            <button type="submit" 
                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-center text-sm transition">
                Guardar Cambios
            </button>

            <a href="{{ route('orders.show', $order->id) }}" 
               class="flex-1 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-xl text-center text-sm transition">
               Volver a Detalles
            </a>
        </div>

    </form>

</x-layouts.app>
