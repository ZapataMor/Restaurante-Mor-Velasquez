<x-layouts.app :title="__('Nuevo Usuario')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-3xl mx-auto">
        
        <!-- Header -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold">Nuevo Usuario</h1>
            <p class="text-neutral-600 dark:text-neutral-400 mt-1">Registra un nuevo empleado en el sistema</p>
        </div>

        <!-- Formulario -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Información Personal -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold border-b border-neutral-200 dark:border-neutral-700 pb-2">
                        Información Personal
                    </h3>

                    <!-- Nombre Completo -->
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">
                            Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            required
                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-neutral-700 dark:text-white"
                            placeholder="Ej: Juan Pérez">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email y Teléfono -->
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required
                                class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-neutral-700 dark:text-white"
                                placeholder="ejemplo@correo.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium mb-2">
                                Teléfono
                            </label>
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-neutral-700 dark:text-white"
                                placeholder="Ej: +57 300 1234567">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información de Acceso -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold border-b border-neutral-200 dark:border-neutral-700 pb-2">
                        Información de Acceso
                    </h3>

                    <!-- Contraseña y Confirmación -->
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="password" class="block text-sm font-medium mb-2">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                minlength="6"
                                class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-neutral-700 dark:text-white"
                                placeholder="Mínimo 6 caracteres">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium mb-2">
                                Confirmar Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required
                                minlength="6"
                                class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-neutral-700 dark:text-white"
                                placeholder="Repite la contraseña">
                        </div>
                    </div>
                </div>

                <!-- Rol y Estado -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold border-b border-neutral-200 dark:border-neutral-700 pb-2">
                        Configuración del Sistema
                    </h3>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <!-- Rol -->
                        <div>
                            <label for="role" class="block text-sm font-medium mb-2">
                                Rol <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="role" 
                                name="role" 
                                required
                                class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-neutral-700 dark:text-white">
                                <option value="">Selecciona un rol</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="mesero" {{ old('role') === 'mesero' ? 'selected' : '' }}>Mesero</option>
                                <option value="recepcionista" {{ old('role') === 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                                <option value="chef" {{ old('role') === 'chef' ? 'selected' : '' }}>Chef</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="active" class="block text-sm font-medium mb-2">
                                Estado
                            </label>
                            <div class="flex items-center h-[42px] px-4 border border-neutral-300 dark:border-neutral-600 rounded-lg dark:bg-neutral-700">
                                <input 
                                    type="checkbox" 
                                    id="active" 
                                    name="active" 
                                    value="1"
                                    {{ old('active', true) ? 'checked' : '' }}
                                    class="w-4 h-4 text-purple-600 focus:ring-purple-500 dark:focus:ring-purple-600 rounded">
                                <label for="active" class="ml-2 text-sm">
                                    Usuario activo
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción de roles -->
                    <div class="bg-neutral-50 dark:bg-neutral-700/50 rounded-lg p-4">
                        <p class="text-sm font-medium mb-2">Descripción de roles:</p>
                        <ul class="text-sm text-neutral-600 dark:text-neutral-400 space-y-1">
                            <li><strong>Administrador:</strong> Acceso completo al sistema</li>
                            <li><strong>Mesero:</strong> Gestión de órdenes y mesas</li>
                            <li><strong>Recepcionista:</strong> Gestión de reservas</li>
                            <li><strong>Chef:</strong> Vista de cocina y preparación</li>
                        </ul>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex gap-3 pt-4">
                    <button 
                        type="submit"
                        class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors font-medium">
                        Crear Usuario
                    </button>
                    <a 
                        href="{{ route('users.index') }}"
                        class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 rounded-lg transition-colors font-medium">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-layouts.app>