<x-layouts.app :title="__('Gestión de Productos')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold">Gestión de Productos</h1>
                <p class="text-neutral-600 dark:text-neutral-400 mt-1">Administra el menú del restaurante</p>
            </div>
            <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Producto
            </a>
        </div>

        <!-- Mensajes -->
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Grid de Productos -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($products as $product)
                <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden hover:shadow-lg transition-shadow">
                    
                    <!-- Imagen -->
                    <div class="relative h-48 bg-neutral-100 dark:bg-neutral-700">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Badge de Estado -->
                        <div class="absolute top-2 right-2">
                            <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full backdrop-blur-sm
                                {{ $product->status === 'Activo' ? 'bg-green-500/90 text-white' : 'bg-gray-500/90 text-white' }}">
                                {{ $product->status }}
                            </span>
                        </div>

                        <!-- Badge de Categoría -->
                        <div class="absolute top-2 left-2">
                            <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full backdrop-blur-sm
                                @if($product->category === 'Entrada') bg-blue-500/90 text-white
                                @elseif($product->category === 'Plato Fuerte') bg-red-500/90 text-white
                                @elseif($product->category === 'Bebida') bg-cyan-500/90 text-white
                                @elseif($product->category === 'Postre') bg-pink-500/90 text-white
                                @else bg-purple-500/90 text-white
                                @endif">
                                {{ $product->category }}
                            </span>
                        </div>
                    </div>

                    <!-- Contenido -->
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1 truncate">{{ $product->name }}</h3>
                        
                        @if($product->description)
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-2 mb-3">
                                {{ $product->description }}
                            </p>
                        @endif

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-amber-600 dark:text-amber-400">
                                ${{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Acciones -->
                        <div class="flex gap-2">
                            <a href="{{ route('products.edit', $product) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition-colors text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center p-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-24 h-24 mx-auto text-neutral-300 dark:text-neutral-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-neutral-500 dark:text-neutral-400 text-lg font-medium mb-2">No hay productos registrados</p>
                    <p class="text-neutral-400 dark:text-neutral-500 text-sm">Comienza agregando tu primer producto al menú</p>
                </div>
            @endforelse
        </div>

        <!-- Botón volver -->
        <div class="flex justify-start">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al Dashboard
            </a>
        </div>

    </div>
</x-layouts.app>