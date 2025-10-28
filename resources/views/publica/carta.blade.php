<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')

    <style>
        /* ===== Animación personalizada ===== */
        .tracking-in-expand-forward-top {
            animation: tracking-in-expand-forward-top 0.8s ease-out both;
        }

        @keyframes tracking-in-expand-forward-top {
            0% {
                letter-spacing: -0.2em;
                transform: translateZ(-700px) translateY(-100px);
                opacity: 0;
            }

            40% {
                opacity: 0.6;
            }

            100% {
                transform: translateZ(0) translateY(0);
                opacity: 1;
            }
        }

        .rotate-vertical-center {
            animation: rotate-vertical-center 1.5s ease-in-out both;
        }

        @keyframes rotate-vertical-center {
            0% {
                transform: rotateY(0);
            }

            100% {
                transform: rotateY(360deg);
            }
        }
    </style>

</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <img src="{{ asset('images/comidaelegante.jpg') }}" alt="Restaurante Mor Velasquez"
        class="absolute inset-0 w-full h-full object-cover -z-10" />

    <div>
        <flux:navbar
            class="fixed top-0 left-0 w-full z-50 border-b border-white/20 
            bg-white/30 dark:bg-zinc-900/30 
            backdrop-blur-md shadow-sm dark:border-zinc-700">

            <div>
                <h1 class="font-bold pl-8">Restaurante Mor Velasquez</h1>
            </div>

            <flux:spacer />

            <div>
                <flux:navlist variant="outline">
                    <flux:navlist.group class="flex space-x-4">

                        <div class="flex flex-col gap-1 pr-6">
                            <flux:navlist.item :href="route('inicio')" :current="request()->routeIs('inicio')"
                                wire:navigate>{{ __('Inicio') }}
                            </flux:navlist.item>
                        </div>

                        <div class="flex flex-col gap-1 pr-6">
                            <flux:navlist.item :href="route('carta')" :current="request()->routeIs('carta')"
                                wire:navigate>{{ __('Carta') }}
                            </flux:navlist.item>
                        </div>

                        <div class="flex flex-col gap-1 pr-6">
                            <flux:navlist.item :href="route('login')" :current="request()->routeIs('login')"
                                wire:navigate>{{ __('Login') }}
                            </flux:navlist.item>
                        </div>

                    </flux:navlist.group>

                </flux:navlist>
            </div>

        </flux:navbar>
    </div>

    <div class="pt-32 pb-20">

        <div class="border border-none rounded-4xl mx-32 py-20 bg-white/5 backdrop-blur text-center">
            <h1 class="text-7xl font-serif text-white drop-shadow-lg tracking-in-expand-forward-top">
                ～ Nuestra Carta ～
            </h1>
            <h2 class="text-3xl pt-10 font-serif text-white tracking-in-expand-forward-top" style="animation-delay: 0.5s;">
                Descubre nuestros deliciosos platos
            </h2>
        </div>
    </div>

    <div class="relative overflow-hidden">

        <img src="{{ asset('images/comidaelegante.jpg') }}" alt="Fondo borroso" aria-hidden="true"
            class="absolute inset-0 w-full h-full object-cover blur-lg opacity-50 -z-10" />

        <div class="container mx-auto px-10 py-20 relative z-10">

            <div class="text-center text-white text-4xl">

                <h2 class="mb-12 font-serif"> Sugerencias </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 text-2xl">

                    <!-- Platos -->
                    <div>
                        <div class="mb-8">
                            <h3 class="mb-4 bg-white/40 font-black text-black dark:text-black p-3 rounded-lg"> Platos </h3>
                        </div>

                        <div class="p-4 mb-6 bg-white/10 backdrop-blur rounded-lg">
                            <div class="flex justify-between text-lg mb-4">
                                <h3 class="text-left"> Tequeyoyo </h3>
                                <h3 class="text-right text-base"> $15.99 </h3>
                            </div>
                            <h3 class="text-sm text-left"> Plato tradicional hecho con ingredientes frescos y sabrosos. </h3>
                        </div>

                        <div class="p-4 mb-6 bg-white/10 backdrop-blur rounded-lg">
                            <div class="flex justify-between text-lg mb-4">
                                <h3 class="text-left"> Arroz con queso </h3>
                                <h3 class="text-right text-base"> $65.99 </h3>
                            </div>
                            <h3 class="text-sm text-left"> Cule vaina sabrosa compa. </h3>
                        </div>

                        <div class="p-4 mb-6 bg-white/10 backdrop-blur rounded-lg">
                            <div class="flex justify-between text-lg mb-4">
                                <h3 class="text-left"> Tajada con suero </h3>
                                <h3 class="text-right text-base"> $80.99 </h3>
                            </div>
                            <h3 class="text-sm text-left"> El suero bien rancio pero potente, manda pal baño. </h3>
                        </div>

                        <div class="p-4 mb-6 bg-white/10 backdrop-blur rounded-lg">
                            <div class="flex justify-between text-lg mb-4">
                                <h3 class="text-left"> Yuca con queso </h3>
                                <h3 class="text-right text-base"> $100.99 </h3>
                            </div>
                            <h3 class="text-sm text-left"> Yuca y botellon, nutritiva y para donde las burritas. </h3>
                        </div>

                    </div>

                    <!-- Bebidas -->
                    <div>
                        <div class="mb-8">
                            <h3 class="mb-4 bg-white/40 font-black text-black dark:text-black p-3 rounded-lg"> Bebidas </h3>
                        </div>

                        <div class="p-4 mb-6 bg-white/10 backdrop-blur rounded-lg">
                            <div class="flex justify-between text-lg mb-4">
                                <h3 class="text-left"> Agua de calson </h3>
                                <h3 class="text-right text-base"> $30.00 </h3>
                            </div>
                            <h3 class="text-sm text-left"> Para enamorar a cualquier pelagato por ahi. </h3>
                        </div>

                        <div class="p-4 mb-6 bg-white/10 backdrop-blur rounded-lg">
                            <div class="flex justify-between text-lg mb-4">
                                <h3 class="text-left"> Agua de maiz </h3>
                                <h3 class="text-right text-base"> $73.99 </h3>
                            </div>
                            <h3 class="text-sm text-left"> Quita la sed, 100% real no fake. </h3>
                        </div>

                        <div class="p-4 mb-6 bg-white/10 backdrop-blur rounded-lg">
                            <div class="flex justify-between text-lg mb-4">
                                <h3 class="text-left"> Jugo de corozo </h3>
                                <h3 class="text-right text-base"> $1,000,000.99 </h3>
                            </div>
                            <h3 class="text-sm text-left"> El jugo mas sabroso de este mundo. </h3>
                        </div>

                        <div class="p-4 mb-6 bg-white/10 backdrop-blur rounded-lg">
                            <div class="flex justify-between text-lg mb-4">
                                <h3 class="text-left"> Chicha de arroz </h3>
                                <h3 class="text-right text-base"> $10.99 </h3>
                            </div>
                            <h3 class="text-sm text-left"> La hacen los wayuu masticando el maiz, qle diarrea asegurada. </h3>
                        </div>

                    </div>

                </div>

                <!-- Cocteles -->
                <div class="mt-12">
                    <div class="mb-8">
                        <h3 class="mb-4 bg-white/40 font-black text-black text-2xl dark:text-black p-3 rounded-lg"> Cocteles </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="p-4 bg-white/10 backdrop-blur rounded-lg">
                            <div class="flex justify-between text-lg mb-4">
                                <h3 class="text-left"> Mojito Tropical </h3>
                                <h3 class="text-right text-base"> $45.00 </h3>
                            </div>
                            <h3 class="text-sm text-left"> Refrescante bebida con ron y menta. </h3>
                        </div>

                        <div class="p-4 bg-white/10 backdrop-blur rounded-lg">
                            <div class="flex justify-between text-lg mb-4">
                                <h3 class="text-left"> Margarita de Corozo </h3>
                                <h3 class="text-right text-base"> $55.99 </h3>
                            </div>
                            <h3 class="text-sm text-left"> Con el toque especial de la casa. </h3>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</body>

</html>