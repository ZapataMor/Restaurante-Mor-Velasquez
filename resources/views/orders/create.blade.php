<x-layouts.app :title="__('Nueva Orden')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h2 class="text-2xl font-bold mb-6">Crear Nueva Orden</h2>

            <form method="POST" action="{{ route('orders.store') }}" id="order-form">
                @csrf

                <!-- Selección de Mesa -->
                @if($selectedTableId)
                    <!-- Si viene table_id en la URL, lo ponemos en un input hidden -->
                    <input type="hidden" name="table_id" value="{{ $selectedTableId }}">
                    <p>Mesa seleccionada: {{ $tables->find($selectedTableId)->number }}</p>
                @else
                    <!-- Si no viene table_id, mostramos el select -->
                    <label class="block text-sm font-medium mb-2">Mesa *</label>
                    <select name="table_id" required class="w-full rounded-lg ...">
                        <option value="">Seleccione una mesa</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}">
                                Mesa {{ $table->number }} - Capacidad: {{ $table->capacity }} personas
                            </option>
                        @endforeach
                    </select>
                @endif


                <!-- Tipo de Orden -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Tipo de Orden *</label>
                    <select name="type" required 
                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 px-4 py-2">
                        <option value="Normal">Normal</option>
                        <option value="Extra">Extra (Urgente)</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cliente (Opcional) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Cliente (Opcional)</label>
                    <select name="customer_id" 
                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 px-4 py-2">
                        <option value="">Sin cliente</option>
                    </select>
                </div>

                <!-- Productos -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-4">Productos *</label>
                    
                    <div id="products-container" class="space-y-4">
                        <!-- Producto inicial -->
                        <div class="product-item border border-neutral-200 dark:border-neutral-700 rounded-lg p-4">
                            <div class="grid md:grid-cols-12 gap-4">
                                <div class="md:col-span-6">
                                    <label class="block text-sm font-medium mb-2">Producto</label>
                                    <select name="items[0][product_id]" required 
                                        class="product-select w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 px-4 py-2">
                                        <option value="">Seleccione un producto</option>
                                        @foreach($productos as $product)
                                            <option value="{{ $product->product_id }}" data-price="{{ $product->price }}">
                                                {{ $product->name }} - ${{ number_format($product->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium mb-2">Cantidad</label>
                                    <input type="number" name="items[0][quantity]" value="1" min="1" required
                                        class="quantity-input w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 px-4 py-2">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-medium mb-2">Notas</label>
                                    <input type="text" name="items[0][notes]" 
                                        placeholder="Ej: Sin cebolla"
                                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 px-4 py-2">
                                </div>
                                <div class="md:col-span-1 flex items-end">
                                    <button type="button" onclick="removeProduct(this)" 
                                        class="remove-product-btn w-full bg-red-500 hover:bg-red-600 text-white rounded-lg px-4 py-2 hidden">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="addProduct()" 
                        class="mt-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg px-4 py-2">
                        + Agregar Producto
                    </button>
                </div>

                <!-- Botones -->
                <div class="flex gap-4">
                    <button type="submit" 
                        class="bg-green-500 hover:bg-green-600 text-white rounded-lg px-6 py-2 font-medium">
                        Crear Orden
                    </button>
                    <a href="{{ route('orders.index') }}" 
                        class="bg-gray-500 hover:bg-gray-600 text-white rounded-lg px-6 py-2 font-medium">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

    </div>

    <script>
        let productIndex = 1;

        function addProduct() {
            const container = document.getElementById('products-container');
            const newProduct = document.createElement('div');
            newProduct.className = 'product-item border border-neutral-200 dark:border-neutral-700 rounded-lg p-4';
            newProduct.innerHTML = `
                <div class="grid md:grid-cols-12 gap-4">
                    <div class="md:col-span-6">
                        <label class="block text-sm font-medium mb-2">Producto</label>
                        <select name="items[${productIndex}][product_id]" required 
                            class="product-select w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 px-4 py-2">
                            <option value="">Seleccione un producto</option>
                            @foreach($productos as $product)
                                <option value="{{ $product->product_id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} - ${{ number_format($product->price, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-2">Cantidad</label>
                        <input type="number" name="items[${productIndex}][quantity]" value="1" min="1" required
                            class="quantity-input w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 px-4 py-2">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium mb-2">Notas</label>
                        <input type="text" name="items[${productIndex}][notes]" 
                            placeholder="Ej: Sin cebolla"
                            class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 px-4 py-2">
                    </div>
                    <div class="md:col-span-1 flex items-end">
                        <button type="button" onclick="removeProduct(this)" 
                            class="remove-product-btn w-full bg-red-500 hover:bg-red-600 text-white rounded-lg px-4 py-2">
                            Eliminar
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newProduct);
            productIndex++;

            // Mostrar botones de eliminar si hay más de un producto
            updateRemoveButtons();
        }

        function removeProduct(button) {
            const productItem = button.closest('.product-item');
            productItem.remove();
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            const items = document.querySelectorAll('.product-item');
            items.forEach((item, index) => {
                const removeBtn = item.querySelector('.remove-product-btn');
                if (items.length > 1) {
                    removeBtn.classList.remove('hidden');
                } else {
                    removeBtn.classList.add('hidden');
                }
            });
        }

        // Inicializar
        updateRemoveButtons();
    </script>
</x-layouts.app>

