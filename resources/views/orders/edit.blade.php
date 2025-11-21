<x-layouts.app :title="__('Editar Orden')">

    <!-- Script de productos ANTES de todo -->
    <script>
        window.productsList = {!! json_encode($productos) !!};
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

        <!-- 🔥 Campos ocultos obligatorios para TODOS los usuarios -->
        <input type="hidden" name="table_id" value="{{ $order->table_id }}">
        <input type="hidden" name="user_id" value="{{ $order->user_id }}">
        <input type="hidden" name="reservation_id" value="{{ $order->reservation_id }}">

        <!-- Información general -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-4">Información de la Orden</h3>

            @if(auth()->user()->role === 'mesero')
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
                        <input type="text" name="client_name" value="{{ $order->client_name }}" class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-2 text-sm">
                    </div>

                    <div>
                        <label class="text-sm text-neutral-500">Estado de Pago</label>
                        <select name="payment_status" class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm p-2">
                            <option value="pendiente" {{ $order->payment_status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="pagado" {{ $order->payment_status === 'pagado' ? 'selected' : '' }}>Pagado</option>
                        </select>
                    </div>
                </div>
            @else
                <!-- Chef solo ve la info de la orden pero los campos se envían como hidden -->
                <input type="hidden" name="status" value="{{ $order->status }}">
                <input type="hidden" name="client_name" value="{{ $order->client_name }}">
                <input type="hidden" name="client_document" value="{{ $order->client_document }}">
                <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-sm text-neutral-500">Estado</label>
                        <p class="mt-1 text-neutral-700 dark:text-neutral-200">{{ ucfirst($order->status) }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-neutral-500">Cliente</label>
                        <p class="mt-1 text-neutral-700 dark:text-neutral-200">{{ $order->client_name }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-neutral-500">Mesero</label>
                        <p class="mt-1 text-neutral-700 dark:text-neutral-200">{{ $order->user->name ?? 'Sin asignar' }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Items de la Orden -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-4">Items de la Orden</h3>

            <div id="products-container" class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="product-item border border-neutral-200 dark:border-neutral-700 rounded-xl p-4">
                        <div class="grid md:grid-cols-12 gap-4">

                            <!-- Producto: siempre lectura + hidden -->
                            <div class="md:col-span-4">
                                <label class="text-sm text-neutral-500">Producto</label>
                                <input type="text" readonly value="{{ $item->product->name }}" class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-800 px-4 py-2 text-sm">
                                <input type="hidden" name="items[{{ $item->id }}][product_id]" value="{{ $item->product_id }}">
                            </div>

                            <!-- Cantidad -->
                            <div class="md:col-span-2">
                                <label class="text-sm text-neutral-500">Cantidad</label>
                                @if(auth()->user()->role === 'mesero')
                                    <input type="number" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}" min="1" class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                                @else
                                    <!-- 🔥 Chef: mostrar como texto pero enviar como hidden -->
                                    <p class="mt-1 text-neutral-700 dark:text-neutral-200">{{ $item->quantity }}</p>
                                    <input type="hidden" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}">
                                @endif
                            </div>

                            <!-- Notas -->
                            <div class="md:col-span-3">
                                <label class="text-sm text-neutral-500">Notas</label>
                                @if(auth()->user()->role === 'mesero')
                                    <input type="text" name="items[{{ $item->id }}][notes]" value="{{ $item->notes }}" class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                                @else
                                    <!-- 🔥 Chef: mostrar como texto pero enviar como hidden -->
                                    <p class="mt-1 text-neutral-700 dark:text-neutral-200">{{ $item->notes ?? '-' }}</p>
                                    <input type="hidden" name="items[{{ $item->id }}][notes]" value="{{ $item->notes }}">
                                @endif
                            </div>

                            <!-- Estado: editable por chef y mesero -->
                            <div class="md:col-span-2">
                                <label class="text-sm text-neutral-500">Estado</label>
                                <select name="items[{{ $item->id }}][status]" class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                                    <option value="pendiente" {{ $item->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="preparando" {{ $item->status === 'preparando' ? 'selected' : '' }}>En Preparación</option>
                                    <option value="listo" {{ $item->status === 'listo' ? 'selected' : '' }}>Listo</option>
                                    <option value="cancelado" {{ $item->status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>

                            <!-- Botón eliminar: solo mesero -->
                            @if(auth()->user()->role === 'mesero')
                                <div class="md:col-span-1">
                                    <button type="button" onclick="this.closest('.product-item').remove()" class="mt-6 w-full bg-red-500 hover:bg-red-600 text-white rounded-xl px-3 py-2 text-sm">
                                        Eliminar
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Botón agregar producto: solo mesero -->
            @if(auth()->user()->role === 'mesero')
                <button type="button" id="addProductBtn" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white rounded-xl px-4 py-2 text-sm">
                    + Agregar Producto
                </button>
            @endif
        </div>

        <!-- Acciones -->
        <div class="flex flex-wrap gap-3">
            <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-center text-sm transition">
                Guardar Cambios
            </button>

            <a href="{{ route('orders.show', $order->id) }}" class="flex-1 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-xl text-center text-sm transition">
                Volver a Detalles
            </a>
        </div>
    </form>

    <script>
        let newItemCounter = 0;
        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.getElementById('addProductBtn');
            if(addBtn){
                addBtn.addEventListener('click', addProduct);
            }
        });

        function addProduct() {
            if(!window.productsList || window.productsList.length === 0) {
                alert('No hay productos disponibles');
                return;
            }

            const itemKey = 'new_' + newItemCounter;
            newItemCounter++;
            const container = document.getElementById('products-container');

            const div = document.createElement('div');
            div.classList.add('product-item','border','border-neutral-200','dark:border-neutral-700','rounded-xl','p-4');

            let options = '<option value="">Seleccione un producto</option>';
            window.productsList.forEach(p => {
                options += `<option value="${p.id}">${p.name} - $${p.price}</option>`;
            });

            div.innerHTML = `
                <div class="grid md:grid-cols-12 gap-4">
                    <div class="md:col-span-4">
                        <label class="text-sm text-neutral-500">Producto</label>
                        <select name="items[${itemKey}][product_id]" required class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">${options}</select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm text-neutral-500">Cantidad</label>
                        <input type="number" name="items[${itemKey}][quantity]" value="1" min="1" required class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label class="text-sm text-neutral-500">Notas</label>
                        <input type="text" name="items[${itemKey}][notes]" placeholder="Ej: Sin cebolla" class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm text-neutral-500">Estado</label>
                        <select name="items[${itemKey}][status]" class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-2 py-1 text-sm">
                            <option value="pendiente" selected>Pendiente</option>
                            <option value="preparando">En Preparación</option>
                            <option value="listo">Listo</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="md:col-span-1">
                        <button type="button" onclick="this.closest('.product-item').remove()" class="mt-6 w-full bg-red-500 hover:bg-red-600 text-white rounded-xl px-3 py-2 text-sm">
                            Eliminar
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }
    </script>

</x-layouts.app>