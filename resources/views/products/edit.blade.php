<x-layouts.app :title="__('Editar Producto')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-3xl mx-auto">
        
        <!-- Header -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold">Editar Producto</h1>
            <p class="text-neutral-600 dark:text-neutral-400 mt-1">Actualiza la información de {{ $product->name }}</p>
        </div>

        <!-- Formulario -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold border-b border-neutral-200 dark:border-neutral-700 pb-2">
                        Información Básica
                    </h3>

                    <!-- Nombre del Producto -->
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">
                            Nombre del Producto <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $product->name) }}"
                            required
                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-amber-500 dark:bg-neutral-700 dark:text-white"
                            placeholder="Ej: Pizza Margherita">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoría y Precio -->
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="category" class="block text-sm font-medium mb-2">
                                Categoría <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="category" 
                                name="category" 
                                required
                                class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-amber-500 dark:bg-neutral-700 dark:text-white">
                                <option value="Entrada" {{ old('category', $product->category) === 'Entrada' ? 'selected' : '' }}>Entrada</option>
                                <option value="Plato Fuerte" {{ old('category', $product->category) === 'Plato Fuerte' ? 'selected' : '' }}>Plato Fuerte</option>
                                <option value="Bebida" {{ old('category', $product->category) === 'Bebida' ? 'selected' : '' }}>Bebida</option>
                                <option value="Postre" {{ old('category', $product->category) === 'Postre' ? 'selected' : '' }}>Postre</option>
                                <option value="Adicional" {{ old('category', $product->category) === 'Adicional' ? 'selected' : '' }}>Adicional</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium mb-2">
                                Precio (COP) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500">$</span>
                                <input 
                                    type="number" 
                                    id="price" 
                                    name="price" 
                                    value="{{ old('price', $product->price) }}"
                                    required
                                    min="0"
                                    step="0.01"
                                    class="w-full pl-8 pr-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-amber-500 dark:bg-neutral-700 dark:text-white"
                                    placeholder="0.00">
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="description" class="block text-sm font-medium mb-2">
                            Descripción
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-amber-500 dark:bg-neutral-700 dark:text-white resize-none"
                            placeholder="Describe el producto, ingredientes principales, etc.">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Imagen -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold border-b border-neutral-200 dark:border-neutral-700 pb-2">
                        Imagen del Producto
                    </h3>

                    <!-- Imagen actual -->
                    @if($product->image)
                        <div>
                            <p class="text-sm font-medium mb-2">Imagen actual:</p>
                            <div class="relative inline-block">
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="max-h-48 rounded-lg border border-neutral-200 dark:border-neutral-700">
                            </div>
                        </div>
                    @endif

                    <div>
                        <label for="image" class="block text-sm font-medium mb-2">
                            {{ $product->image ? 'Cambiar imagen' : 'Agregar imagen' }}
                        </label>
                        <div class="mt-2">
                            <div class="flex items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-neutral-300 dark:border-neutral-600 border-dashed rounded-lg cursor-pointer bg-neutral-50 dark:bg-neutral-700/50 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-12 h-12 mb-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="mb-2 text-sm text-neutral-500 dark:text-neutral-400">
                                            <span class="font-semibold">Clic para cargar</span> o arrastra y suelta
                                        </p>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">PNG, JPG, JPEG o GIF (MAX. 2MB)</p>
                                    </div>
                                    <input 
                                        id="image" 
                                        name="image" 
                                        type="file" 
                                        class="hidden" 
                                        accept="image/jpeg,image/png,image/jpg,image/gif"
                                        onchange="previewImage(event)">
                                </label>
                            </div>
                            
                            <!-- Preview de la nueva imagen -->
                            <div id="imagePreview" class="mt-4 hidden">
                                <p class="text-sm font-medium mb-2">Nueva imagen:</p>
                                <div class="relative inline-block">
                                    <img id="preview" src="" alt="Preview" class="max-h-48 rounded-lg border border-neutral-200 dark:border-neutral-700">
                                    <button 
                                        type="button" 
                                        onclick="removeImage()"
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Estado -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold border-b border-neutral-200 dark:border-neutral-700 pb-2">
                        Disponibilidad
                    </h3>

                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="status" 
                            name="status" 
                            required
                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-amber-500 dark:bg-neutral-700 dark:text-white">
                            <option value="Activo" {{ old('status', $product->status) === 'Activo' ? 'selected' : '' }}>Activo (Visible en el menú)</option>
                            <option value="Inactivo" {{ old('status', $product->status) === 'Inactivo' ? 'selected' : '' }}>Inactivo (Oculto del menú)</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200">Información del producto</p>
                            <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                Creado: {{ $product->created_at->format('d/m/Y H:i') }}<br>
                                Última actualización: {{ $product->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex gap-3 pt-4">
                    <button 
                        type="submit"
                        class="flex-1 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition-colors font-medium">
                        Guardar Cambios
                    </button>
                    <a 
                        href="{{ route('products.index') }}"
                        class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 rounded-lg transition-colors font-medium">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('preview').src = '';
        }
    </script>
</x-layouts.app>