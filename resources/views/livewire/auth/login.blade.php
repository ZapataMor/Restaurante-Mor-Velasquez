<x-layouts.auth>
    <div class="px-6 md:px-10 py-5 flex flex-col gap-6">
        <x-auth-header :title="__('Inicia sesion')" :description="__('Ingresa tus credenciales')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input name="email" :label="__('Correo eléctronico')" type="email" required autocomplete="email"
                placeholder="Escribe tu correo" />

            <div class="relative">
                <flux:input name="password" :label="__('Contraseña')" type="password" required
                    autocomplete="current-password" :placeholder="__('Escribe tu contraseña')" viewable />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-xs md:text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </flux:link>
                @endif
            </div>

            <flux:checkbox name="remember" :label="__('Recuerdame')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full btn-login" data-test="login-button">
                    {{ __('Iniciar sesión') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-xs md:text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('¿No tienes cuenta?') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('Registrarse') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts.auth>