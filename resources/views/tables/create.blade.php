{{-- resources/views/tables/create.blade.php --}}
<x-layouts.app :title="isset($table) ? 'Editar Mesa' : 'Nueva Mesa'">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-2xl mx-auto">
        
        <!-- Header -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold">{{ isset($table) ? 'Editar Mesa' : 'Nueva Mesa' }}</h1>
            <p class="text-neutral-600 dark:text-neutral-400 mt-1">Complete los datos de la mesa</p>
        </div>

        <!-- Formulario -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <form action="{{ isset($table) ? route('tables.update', $table) : route('tables.store') }}" method="POST" class="space-y-6">
                @csrf
                @if(isset($table))
                    @method('PUT')
                @endif

                <!-- Número de Mesa -->
                <div>
                    <label for="number" class="block text-sm font-medium mb-2">
                        Número de Mesa <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="number" 
                        name="number" 
                        value="{{ old('number', $table->number ?? '') }}"
                        required
                        min="1"
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:text-white"
                        placeholder="Ej: 1">
                    @error('number')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capacidad -->
                <div>
                    <label for="capacity" class="block text-sm font-medium mb-2">
                        Capacidad (Personas) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="capacity" 
                        name="capacity" 
                        value="{{ old('capacity', $table->capacity ?? '') }}"
                        required
                        min="1"
                        max="20"
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:text-white"
                        placeholder="Ej: 4">
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="status" class="block text-sm font-medium mb-2">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="status" 
                        name="status" 
                        required
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:text-white">
                        <option value="Disponible" {{ old('status', $table->status ?? '') === 'Disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="Ocupada" {{ old('status', $table->status ?? '') === 'Ocupada' ? 'selected' : '' }}>Ocupada</option>
                        <option value="Reservada" {{ old('status', $table->status ?? '') === 'Reservada' ? 'selected' : '' }}>Reservada</option>
                        <option value="Necesita Limpieza" {{ old('status', $table->status ?? '') === 'Necesita Limpieza' ? 'selected' : '' }}>Necesita Limpieza</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex gap-3 pt-4">
                    <button 
                        type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                        {{ isset($table) ? 'Actualizar Mesa' : 'Crear Mesa' }}
                    </button>
                    <a 
                        href="{{ route('tables.index') }}"
                        class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 rounded-lg transition-colors font-medium">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-layouts.app>

{{-- resources/views/tables/edit.blade.php --}}
{{-- Este archivo solo necesita incluir el create.blade.php ya que ambos usan el mismo formulario --}}
@include('tables.create')