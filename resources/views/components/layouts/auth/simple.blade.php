<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased dark:bg-gradient-to-b dark:from-neutral-950 dark:to-neutral-900">

    <div class="flex min-h-svh flex-col items-center justify-center gap-4 sm:gap-6 p-4 sm:p-6 md:p-10">

        <img src="{{ asset('images/entrada.jpg') }}" alt="Restaurante Mor Velasquez"
            class="absolute inset-0 w-full h-full object-cover -z-10 blur-sm opacity-80" />

        <!-- Título principal -->
        <div class="w-full max-w-4xl mb-8 sm:mb-12 md:mb-20 mt-8 sm:mt-12 md:mt-20 py-6 sm:py-10 md:py-15 px-4 sm:px-8 md:px-20 
                    rounded-xl border border-white/20 bg-white/30 dark:bg-zinc-900/30 backdrop-blur-md 
                    animate-[scale-up_1s_ease-out_both]">
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-serif text-center leading-tight">
                Bienvenidos al restaurante Mor Velasquez
            </h1>
        </div>

        <!-- Contenedor del formulario -->
        <div class="flex w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl flex-col gap-2 
                    rounded-xl border border-white/20 bg-white/30 dark:bg-zinc-900/30 backdrop-blur-md 
                    animate-[scale-up_1s_ease-out_0.3s_both]">
            <div class="flex flex-col gap-6">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Animación en Tailwind CSS -->
    <style>
        @keyframes scale-up {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    @fluxScripts
</body>

</html>