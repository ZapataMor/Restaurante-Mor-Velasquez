<x-layouts.app :title="__('Editar Orden')">

    <!-- Script de productos ANTES de todo -->
    <script>
        // 🔥 Cargar productos ANTES de que se cargue orders.js
        window.productsList = {!! json_encode($productos) !!};
        console.log('✅ Productos precargados:', window.productsList ? window.productsList.length : 0);
    </script>

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

            <div id="products-container" class="space-y-4">

                <!-- Items existentes -->
                @foreach($order->orderItems as $item)
                    <div class="product-item border border-neutral-200 dark:border-neutral-700 rounded-xl p-4">
                        <div class="grid md:grid-cols-12 gap-4">

                            <!-- Producto (solo lectura) -->
                            <div class="md:col-span-4">
                                <label class="text-sm text-neutral-500">Producto</label>
                                <input type="text" readonly value="{{ $item->product->name }}"
                                    class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-800 px-4 py-2 text-sm">
                                
                                <!-- Item existente usa su ID real como clave -->
                                <input type="hidden" name="items[{{ $item->id }}][product_id]" value="{{ $item->product_id }}">
                            </div>

                            <!-- Cantidad -->
                            <div class="md:col-span-2">
                                <label class="text-sm text-neutral-500">Cantidad</label>
                                <input type="number" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}" min="1"
                                    class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                            </div>

                            <!-- Notas -->
                            <div class="md:col-span-3">
                                <label class="text-sm text-neutral-500">Notas</label>
                                <input type="text" name="items[{{ $item->id }}][notes]" value="{{ $item->notes }}"
                                    class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                            </div>

                            <!-- Estado -->
                            <div class="md:col-span-2">
                                <label class="text-sm text-neutral-500">Estado</label>
                                <select name="items[{{ $item->id }}][status]"
                                    class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                                    <option value="pendiente"   {{ $item->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="preparando"  {{ $item->status === 'preparando' ? 'selected' : '' }}>En Preparación</option>
                                    <option value="listo"       {{ $item->status === 'listo' ? 'selected' : '' }}>Listo</option>
                                    <option value="cancelado"   {{ $item->status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Botón agregar producto -->
            <button type="button" id="addProductBtn" 
                class="mt-4 bg-blue-500 hover:bg-blue-600 text-white rounded-xl px-4 py-2 text-sm">
                + Agregar Producto
            </button>
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

    <script>
    // Lista de productos disponibles
    const productsList = {!! json_encode($productos) !!};
    
    // Validar que productsList exista
    if (!productsList || productsList.length === 0) {
        console.error('No hay productos disponibles');
    } else {
        console.log('Productos cargados:', productsList.length);
    }
    
    // Contador para nuevos items
    let newItemCounter = 0;

    // Event listener para el botón
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('addProductBtn');
        if (addBtn) {
            addBtn.addEventListener('click', addProduct);
        }
    });

    function addProduct() {
        // Validar que haya productos
        if (!productsList || productsList.length === 0) {
            alert('No hay productos disponibles');
            return;
        }

        // Crear clave única con prefijo "new_"
        const itemKey = 'new_' + newItemCounter;
        newItemCounter++;

        console.log('Agregando producto con clave:', itemKey); // Debug

        const container = document.getElementById('products-container');

        const div = document.createElement('div');
        div.classList.add('product-item', 'border', 'border-neutral-200', 'dark:border-neutral-700', 'rounded-xl', 'p-4');
        
        // Construir el HTML con template literals
        let productOptions = '<option value="">Seleccione un producto</option>';
        productsList.forEach(function(p) {
            productOptions += `<option value="${p.id}">${p.name} - ${p.price}</option>`;
        });

        div.innerHTML = `
            <div class="grid md:grid-cols-12 gap-4">

                <div class="md:col-span-4">
                    <label class="text-sm text-neutral-500">Producto</label>
                    <select name="items[${itemKey}][product_id]" required 
                        class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
                        ${productOptions}
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm text-neutral-500">Cantidad</label>
                    <input type="number" name="items[${itemKey}][quantity]" value="1" min="1" required
                        class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                </div>

                <div class="md:col-span-3">
                    <label class="text-sm text-neutral-500">Notas</label>
                    <input type="text" name="items[${itemKey}][notes]" placeholder="Ej: Sin cebolla"
                        class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm text-neutral-500">Estado</label>
                    <select name="items[${itemKey}][status]"
                        class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                        <option value="pendiente" selected>Pendiente</option>
                        <option value="preparando">En Preparación</option>
                        <option value="listo">Listo</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>

                <div class="md:col-span-1">
                    <button type="button" onclick="this.closest('.product-item').remove()"
                        class="remove-product-btn mt-6 w-full bg-red-500 hover:bg-red-600 text-white rounded-xl px-3 py-2 text-sm">
                        Eliminar
                    </button>
                </div>

            </div>
        `;

        container.appendChild(div);
    }
    </script>

</x-layouts.app>