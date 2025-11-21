<x-layouts.app :title="__('Nueva Orden')">

    <!-- HERO superior -->
    <section class="relative w-full rounded-2xl overflow-hidden shadow-lg mb-6">
        <img src="{{ asset('images/Restaurante.jpg') }}"
             class="absolute inset-0 w-full h-full object-cover brightness-[0.45]">
        <div class="relative z-10 p-10 text-white">
            <h2 class="text-4xl font-serif font-bold">🆕 Crear Nueva Orden</h2>
            @if($selectedTableId)
                <p class="text-amber-300 text-lg">
                    Mesa seleccionada: {{ $tables->find($selectedTableId)->number }}
                </p>
            @endif
        </div>
    </section>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <form method="POST" action="{{ route('orders.store') }}" id="order-form" class="flex flex-col gap-6">
        @csrf

        <!-- Información de la Orden -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-4">Información de la Orden</h3>

            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <input type="hidden" name="status" value="abierta">
            <input type="hidden" name="payment_status" value="pendiente">


            <!-- Mesa -->
            @if(!$selectedTableId)
                <div class="mb-4">
                    <label class="text-sm text-neutral-500">Mesa *</label>
                    <select name="table_id" required 
                        class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
                        <option value="">Seleccione una mesa</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}">
                                Mesa {{ $table->number }} - Capacidad: {{ $table->capacity }} personas
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="table_id" value="{{ $selectedTableId }}">
            @endif

            <!-- Tipo de Orden -->
            <div class="mb-4">
                <label class="text-sm text-neutral-500">Tipo de Orden *</label>
                <select name="type" required 
                    class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
                    <option value="Normal">Normal</option>
                    <option value="Extra">Extra (Urgente)</option>
                </select>
            </div>

            <!-- Cliente y Documento -->
            <div class="mb-4 grid md:grid-cols-2 gap-4">

                <!-- Nombre del Cliente -->
                <div>
                    <label class="text-sm text-neutral-500">Nombre del Cliente</label>
                    <input type="text" name="client_name"
                        value="{{ (isset($reservation) && $reservation->table_id == $selectedTableId) ? $reservation->client_name : old('client_name') }}"
                        @if(isset($reservation) && $reservation->table_id == $selectedTableId) readonly @endif
                        placeholder="Ingrese el nombre del cliente"
                        class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
                </div>

                <!-- Documento del Cliente -->
                <div>
                    <label class="text-sm text-neutral-500">Documento</label>
                    <input type="text" name="client_document"
                        value="{{ (isset($reservation) && $reservation->table_id == $selectedTableId) ? $reservation->client_document : old('client_document') }}"
                        @if(isset($reservation) && $reservation->table_id == $selectedTableId) readonly @endif
                        placeholder="Ingrese el documento del cliente"
                        class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
                </div>


        </div>

        <!-- Productos -->
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-6 shadow-sm">
            <h3 class="text-xl font-semibold mb-4">Productos *</h3>

            <div id="products-container" class="space-y-4">
                <div class="product-item border border-neutral-200 dark:border-neutral-700 rounded-xl p-4">
                    <div class="grid md:grid-cols-12 gap-4">
                        <div class="md:col-span-6">
                            <label class="text-sm text-neutral-500">Producto</label>
                            <select name="items[0][product_id]" required 
                                class="product-select mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
                                <option value="">Seleccione un producto</option>
                                @foreach($productos as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->name }} - ${{ number_format($product->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm text-neutral-500">Cantidad</label>
                            <input type="number" name="items[0][quantity]" value="1" min="1" required
                                class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
                        </div>

                        <div class="md:col-span-3">
                            <label class="text-sm text-neutral-500">Notas</label>
                            <input type="text" name="items[0][notes]" placeholder="Ej: Sin cebolla"
                                class="mt-1 w-full rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-4 py-2 text-sm">
                        </div>

                        <div class="md:col-span-1 flex items-end">
                            <button type="button" onclick="removeProduct(this)" 
                                class="remove-product-btn w-full bg-red-500 hover:bg-red-600 text-white rounded-xl px-4 py-2 hidden text-sm">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" onclick="addProduct()" 
                class="mt-4 bg-blue-500 hover:bg-blue-600 text-white rounded-xl px-4 py-2 text-sm">
                + Agregar Producto
            </button>
        </div>

        <!-- Botones de acción -->
        <div class="flex flex-wrap gap-4">
            <button type="submit" 
                class="flex-1 bg-green-600 hover:bg-green-700 text-white rounded-xl px-6 py-2 font-medium text-sm text-center">
                Crear Orden
            </button>
            <a href="{{ route('orders.index') }}" 
                class="flex-1 bg-gray-600 hover:bg-gray-700 text-white rounded-xl px-6 py-2 font-medium text-sm text-center">
                Cancelar
            </a>
        </div>

    </form>

    <script>
        window.productsList = @json($productos);
        window.productIndex = 1;
        console.log(window.productsList);

    </script>

</x-layouts.app>
