<x-layouts.app :title="__('Editar Mesa')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-2xl mx-auto">
        
        <!-- Header -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold">Editar Mesa #{{ $table->number }}</h1>
            <p class="text-neutral-600 dark:text-neutral-400 mt-1">Actualiza los datos de la mesa</p>
        </div>

        <!-- Formulario -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <form action="{{ route('tables.update', $table) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Número de Mesa -->
                <div>
                    <label for="number" class="block text-sm font-medium mb-2">
                        Número de Mesa <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="number" 
                        name="number" 
                        value="{{ old('number', $table->number) }}"
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
                        value="{{ old('capacity', $table->capacity) }}"
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
                        <option value="Disponible" {{ old('status', $table->status) === 'Disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="Ocupada" {{ old('status', $table->status) === 'Ocupada' ? 'selected' : '' }}>Ocupada</option>
                        <option value="Reservada" {{ old('status', $table->status) === 'Reservada' ? 'selected' : '' }}>Reservada</option>
                        <option value="Necesita Limpieza" {{ old('status', $table->status) === 'Necesita Limpieza' ? 'selected' : '' }}>Necesita Limpieza</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Información adicional -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200">Información de la mesa</p>
                            <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                Creada: {{ $table->created_at->format('d/m/Y H:i') }}<br>
                                Última actualización: {{ $table->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex gap-3 pt-4">
                    <button 
                        type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                        Guardar Cambios
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