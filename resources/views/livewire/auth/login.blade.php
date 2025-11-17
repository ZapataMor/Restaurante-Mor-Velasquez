<x-layouts.auth>
    <div class="w-full px-4 sm:px-6 md:px-8 lg:px-10 py-5 sm:py-6 flex flex-col gap-4 sm:gap-6">
        <x-auth-header :title="__('Inicia sesion')" :description="__('Ingresa tus credenciales')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4 sm:gap-6">
            @csrf

            <flux:input 
                name="email" 
                :label="__('Correo eléctronico')" 
                type="email" 
                required 
                autocomplete="email"
                placeholder="Escribe tu correo" 
                class="w-full text-sm sm:text-base" />

            <div class="relative">
                <flux:input 
                    name="password" 
                    :label="__('Contraseña')" 
                    type="password" 
                    required
                    autocomplete="current-password" 
                    :placeholder="__('Escribe tu contraseña')" 
                    viewable 
                    class="w-full text-sm sm:text-base" />

                @if (Route::has('password.request'))
                    <flux:link 
                        class="absolute top-0 end-0 text-xs sm:text-sm whitespace-nowrap hover:underline" 
                        :href="route('password.request')" 
                        wire:navigate>
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </flux:link>
                @endif
            </div>

            <flux:checkbox 
                name="remember" 
                :label="__('Recuerdame')" 
                :checked="old('remember')" 
                class="text-sm sm:text-base" />

            <div class="flex items-center justify-end mt-2">
                <flux:button 
                    variant="primary" 
                    type="submit" 
                    class="w-full relative overflow-hidden z-10
                           px-4 sm:px-6 md:px-8 py-3 sm:py-3.5 md:py-4
                           text-sm sm:text-base md:text-lg lg:text-xl
                           font-semibold uppercase
                           bg-transparent text-gray-400
                           border-2 border-white rounded-lg
                           transition-all duration-500 ease-in-out
                           hover:text-gray-900 dark:hover:text-gray-900
                           before:content-[''] before:absolute before:top-0 before:left-0 
                           before:w-0 before:h-full before:bg-white before:-z-10
                           before:transition-all before:duration-500 before:ease-in-out
                           hover:before:w-full" 
                    data-test="login-button">
                    {{ __('Iniciar sesión') }}
                </flux:button>
            </div>
        </form>

    </div>
</x-layouts.auth>