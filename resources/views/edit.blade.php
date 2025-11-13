<x-layouts.app :title="__('Editar Orden #' . $order->order_id)">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Editar Orden #{{ $order->order_id }}</h1>
                <p class="text-neutral-600 dark:text-neutral-400 mt-1">Modifica los items de la orden</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('orders.show', $order->order_id) }}" 
                   class="px-6 py-3 bg-neutral-200 hover:bg-neutral-300 dark:bg-neutral-700 dark:hover:bg-neutral-600 rounded-lg font-medium transition">
                    Cancelar
                </a>
            </div>
        </div>

        @if($order->status === 'Pagada' || $order->status === 'Entregada')
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <p class="font-semibold text-red-800 dark:text-red-200">No se puede editar esta orden</p>
                        <p class="text-sm text-red-700 dark:text-red-300">Las órdenes pagadas o entregadas no pueden ser modificadas</p>
                    </div>
                </div>
            </div>
        @else
            <form action="{{ route('orders.update', $order->order_id) }}" method="POST" id="orderForm">
                @csrf
                @method('PUT')
                
                <div class="grid lg:grid-cols-3 gap-6">
                    
                    <!-- Información de la Orden -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Items Actuales (Solo Lectura para items Listos) -->
                        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                            <h3 class="text-lg font-semibold mb-4">Items de la Orden Actual</h3>
                            
                            <div class="space-y-3 mb-4">
                                @foreach($order->orderItems as $item)
                                    <div class="p-4 border border-neutral-200 dark:border-neutral-700 rounded-lg
                                        @if($item->status === 'Listo') bg-green-50 dark:bg-green-900/10 @endif">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <span class="text-xl font-bold">{{ $item->quantity }}x</span>
                                                <div>
                                                    <p class="font-semibold">{{ $item->product->name }}</p>
                                                    <p class="text-sm text-neutral-500">${{ number_format($item->product->price, 2) }}</p>
                                                    @if($item->notes)
                                                        <p class="text-xs text-neutral-500 mt-1">📝 {{ $item->notes }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-block px-3 py-1 text-xs font-medium rounded-full mb-1
                                                    @if($item->status === 'Pendiente') bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200
                                                    @elseif($item->status === 'En Preparación') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                                                    @elseif($item->status === 'Listo') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                                                    @endif">
                                                    {{ $item->status }}
                                                </span>
                                                @if($item->status === 'Listo')
                                                    <p class="text-xs text-green-600 dark:text-green-400">No se puede modificar</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    💡 <strong>Nota:</strong> Solo puedes agregar nuevos items. Los items que ya están "Listos" no se pueden modificar ni eliminar.
                                </p>
                            </div>
                        </div>

                        <!-- Agregar Nuevos Productos -->
                        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                            <h3 class="text-lg font-semibold mb-4">Agregar Nuevos Items</h3>
                            
                            <div class="mb-4">
                                <input type="text" id="searchProduct" placeholder="Buscar producto..."
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>

                            <div id="productsList" class="grid md:grid-cols-2 gap-3 max-h-96 overflow-y-auto">
                                @foreach($products as $product)
                                    <div class="product-item p-4 border border-neutral-200 dark:border-neutral-700 rounded-lg hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition"
                                         data-product-id="{{ $product->product_id }}"
                                         data-product-name="{{ $product->name }}"
                                         data-product-price="{{ $product->price }}"
                                         onclick="addProduct({{ $product->product_id }}, '{{ $product->name }}', {{ $product->price }})">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-semibold">{{ $product->name }}</h4>
                                                @if($product->description)
                                                    <p class="text-xs text-neutral-500 mt-1">{{ Str::limit($product->description, 50) }}</p>
                                                @endif
                                            </div>
                                            <span class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                                ${{ number_format($product->price, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de Nuevos Items -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 sticky top-6">
                            <h3 class="text-lg font-semibold mb-4">Nuevos Items a Agregar</h3>
                            
                            <div id="newItems" class="space-y-3 mb-4 max-h-96 overflow-y-auto">
                                <div id="emptyState" class="text-center py-8 text-neutral-500">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="text-sm">Selecciona productos para agregar</p>
                                </div>
                            </div>

                            <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4 mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium">Nuevos Items:</span>
                                    <span id="newItemsCount" class="font-bold">0</span>
                                </div>
                                <div class="flex items-center justify-between text-lg">
                                    <span class="font-semibold">Subtotal:</span>
                                    <span id="newItemsTotal" class="font-bold text-blue-600 dark:text-blue-400">$0.00</span>
                                </div>
                            </div>

                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition disabled:opacity-50 disabled:cursor-not-allowed"
                                    id="submitBtn" disabled>
                                Actualizar Orden
                            </button>

                            <p class="text-xs text-center text-neutral-500 mt-3">
                                Los items existentes se mantendrán
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs for new items -->
                <div id="hiddenInputs"></div>
            </form>
        @endif

    </div>

    @push('scripts')
    <script>
        let newItems = [];

        // Buscar productos
        document.getElementById('searchProduct').addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(item => {
                const name = item.dataset.productName.toLowerCase();
                item.style.display = name.includes(search) ? 'block' : 'none';
            });
        });

        // Agregar producto
        function addProduct(id, name, price) {
            const existingIndex = newItems.findIndex(item => item.id === id);
            
            if (existingIndex !== -1) {
                newItems[existingIndex].quantity++;
            } else {
                newItems.push({
                    id: id,
                    name: name,
                    price: parseFloat(price),
                    quantity: 1,
                    notes: ''
                });
            }
            
            updateNewItemsSummary();
        }

        // Eliminar producto
        function removeProduct(id) {
            newItems = newItems.filter(item => item.id !== id);
            updateNewItemsSummary();
        }

        // Actualizar cantidad
        function updateQuantity(id, quantity) {
            const item = newItems.find(item => item.id === id);
            if (item) {
                item.quantity = parseInt(quantity) || 1;
                updateNewItemsSummary();
            }
        }

        // Actualizar notas
        function updateNotes(id, notes) {
            const item = newItems.find(item => item.id === id);
            if (item) {
                item.notes = notes;
            }
        }

        // Actualizar resumen
        function updateNewItemsSummary() {
            const container = document.getElementById('newItems');
            const hiddenInputs = document.getElementById('hiddenInputs');
            const submitBtn = document.getElementById('submitBtn');
            
            if (newItems.length === 0) {
                container.innerHTML = `
                    <div id="emptyState" class="text-center py-8 text-neutral-500">
                        <svg class="w-12 h-12 mx-auto mb-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <p class="text-sm">Selecciona productos para agregar</p>
                    </div>
                `;
                hiddenInputs.innerHTML = '';
                submitBtn.disabled = true;
                document.getElementById('newItemsCount').textContent = '0';
                document.getElementById('newItemsTotal').textContent = '$0.00';
                return;
            }

            // Actualizar items visibles
            container.innerHTML = newItems.map(item => `
                <div class="p-3 border border-neutral-200 dark:border-neutral-700 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <h4 class="font-medium text-sm">${item.name}</h4>
                            <p class="text-xs text-neutral-500">$${item.price.toFixed(2)} c/u</p>
                        </div>
                        <button type="button" onclick="removeProduct(${item.id})" 
                                class="text-red-500 hover:text-red-700 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <label class="text-xs">Cantidad:</label>
                        <input type="number" min="1" value="${item.quantity}"
                               onchange="updateQuantity(${item.id}, this.value)"
                               class="w-16 px-2 py-1 text-sm border border-neutral-300 dark:border-neutral-600 rounded bg-white dark:bg-neutral-700">
                        <span class="text-xs font-medium">= $${(item.price * item.quantity).toFixed(2)}</span>
                    </div>
                    <input type="text" placeholder="Notas especiales..."
                           onchange="updateNotes(${item.id}, this.value)"
                           class="w-full px-2 py-1 text-xs border border-neutral-300 dark:border-neutral-600 rounded bg-white dark:bg-neutral-700">
                </div>
            `).join('');

            // Actualizar hidden inputs
            hiddenInputs.innerHTML = newItems.map((item, index) => `
                <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                <input type="hidden" name="items[${index}][notes]" value="${item.notes}">
            `).join('');

            // Calcular totales
            const totalItems = newItems.reduce((sum, item) => sum + item.quantity, 0);
            const totalPrice = newItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            document.getElementById('newItemsCount').textContent = totalItems;
            document.getElementById('newItemsTotal').textContent = '$' + totalPrice.toFixed(2);
            
            submitBtn.disabled = false;
        }
    </script>
    @endpush
</x-layouts.app>