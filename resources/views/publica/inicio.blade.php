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

        .fade-transition {
            transition: opacity 0.5s ease-in-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Arreglo de imágenes para la imagen izquierda
            const imagenesIzquierda = [
                "{{ asset('images/comida.jpg') }}",
                "{{ asset('images/comida2.jpg') }}",
            ];

            // Arreglo de imágenes para la imagen derecha
            const imagenesDerecha = [
                "{{ asset('images/comida2.jpg') }}",
                "{{ asset('images/comida.jpg') }}"
            ];

            let indiceActual = 0;
            const imagenIzquierda = document.getElementById('imagen-izquierda');
            const imagenDerecha = document.getElementById('imagen-derecha');

            function cambiarYGirarImagenes() {
                // Fade out
                imagenIzquierda.style.opacity = '0';
                imagenDerecha.style.opacity = '0';

                setTimeout(() => {
                    // Cambiar índice
                    indiceActual = (indiceActual + 1) % imagenesIzquierda.length;

                    // Cambiar src de las imágenes
                    imagenIzquierda.src = imagenesIzquierda[indiceActual];
                    imagenDerecha.src = imagenesDerecha[indiceActual];

                    // Remover y volver a agregar la clase de animación para reiniciar
                    imagenIzquierda.classList.remove('rotate-vertical-center');
                    imagenDerecha.classList.remove('rotate-vertical-center');

                    // Forzar reflow
                    void imagenIzquierda.offsetWidth;
                    void imagenDerecha.offsetWidth;

                    // Fade in y agregar animación de rotación
                    imagenIzquierda.style.opacity = '1';
                    imagenDerecha.style.opacity = '1';
                    imagenIzquierda.classList.add('rotate-vertical-center');
                    imagenDerecha.classList.add('rotate-vertical-center');
                }, 500); // Tiempo del fade out
            }

            // Cambiar imágenes cada 5 segundos
            setInterval(cambiarYGirarImagenes, 5000);
        });
    </script>

</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <img src="{{ asset('images/Restaurante.jpg') }}" alt="Restaurante Mor Velasquez"
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

    <div class="pt-70 pb-103">

        <div class="border border-none rounded-4xl mx-32 py-20 bg-white/5 backdrop-blur text-center">
            <h1 class="text-7xl font-serif text-white drop-shadow-lg tracking-in-expand-forward-top">
                ～ Restaurante Mor Velasquez ～
            </h1>
            <h2 class="text-3xl pt-10 font-serif tracking-in-expand-forward-top" style="animation-delay: 0.5s;">
                ¡Bienvenidos a nuestro restaurante!
            </h2>
        </div>
    </div>

    <div class="bg-white flex">

        <div class="flex-2 overflow-hidden">
            <img id="imagen-izquierda" src="{{ asset('images/comida.jpg') }}" alt="Fondo del contenedor"
                class="w-full h-full object-contain scale-100 fade-transition" />
        </div>

        <div class="bg-white font-serif text-center text-black text-xl w-1/4 p-4 pt-10">
            <h1 class="text-4xl mb-4 pt-5 pb-4">El restaurante</h1>
            En Restaurante Mor Velasquez, nos enorgullece ofrecerte una experiencia culinaria excepcional.
            Nuestro menú está cuidadosamente elaborado con ingredientes frescos y de alta calidad para satisfacer
            todos los paladares. Ya sea que busques platos tradicionales o sabores innovadores, nuestro equipo de
            chefs talentosos está listo para deleitarte con creaciones únicas. Ven y disfruta de un ambiente
            acogedor
            y un servicio impecable. ¡Te esperamos para compartir momentos inolvidables alrededor de la buena
            comida!
        </div>

        <div class="flex-2 overflow-hidden">
            <img id="imagen-derecha" src="{{ asset('images/comida2.jpg') }}" alt="Fondo del contenedor"
                class="w-full h-full object-contain scale-100 fade-transition"/>
        </div>

    </div>

    <div class="relative overflow-hidden">

        <img src="{{ asset('images/comidaelegante.jpg') }}" alt="Fondo borroso" aria-hidden="true"
            class="absolute inset-0 w-full h-full object-cover blur-lg opacity-50 -z-10" />

        <div class="grid grid-cols-2 pl-10 relative z-10">

            <div class="text-center text-white text-4xl p-4 pt-20">

                <h2 class="mb-8 font-serif mt-20"> Sugerencias </h2>

                <div class="grid grid-cols-2 text-2xl">

                    <div>
                        <div class="mb-8 pr-4">
                            <h3 class="mb-4 bg-white/40 font-black text-black dark:text-black"> Platos </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Tequeyoyo </h3>
                                <h3 class="text-right text-base"> Precio: $15.99 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: Plato tradicional hecho con ingredientes frescos
                                y
                                sabrosos. </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Arroz con queso </h3>
                                <h3 class="text-right text-base"> Precio: $65.99 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: Cule vaina sabrosa compa. </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Tajada con suero </h3>
                                <h3 class="text-right text-base"> Precio: $80.99 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: El suero bien rancio pero potente, manda pal
                                baño.
                            </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Yuca con queso </h3>
                                <h3 class="text-right text-base"> Precio: $100.99 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: Yuca y botellon, nutritiva y para donde las
                                burritas. </h3>
                        </div>

                    </div>

                    <div>
                        <div class="mb-8 pl-4">
                            <h3 class="mb-4 bg-white/40 font-black text-black dark:text-black"> Bebidas </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Agua de calson </h3>
                                <h3 class="text-right text-base"> Precio: $30.00 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: Para enamorar a cualquier pelagato por ahi.
                            </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Agua de maiz </h3>
                                <h3 class="text-right text-base"> Precio: $73.99 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: Quita la sed, 100% real no fake. </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Jugo de corozo </h3>
                                <h3 class="text-right text-base"> Precio: $1,000,000.99 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: El jugo mas sabroso de este mundo. </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Chicha de arroz </h3>
                                <h3 class="text-right text-base"> Precio: $10.99 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: La hacen los wayuu masticando el maiz, qle
                                diarrea
                                asegurada. </h3>
                        </div>

                    </div>

                </div>

                <div class="pb-20 mx-50">

                    <div>
                        <div class="mb-8">
                            <h3 class="mb-4 bg-white/40 font-black text-black text-2xl dark:text-black"> Cocteles </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Agua de calson </h3>
                                <h3 class="text-right text-base"> Precio: $30.00 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: Para enamorar a cualquier pelagato por ahi.
                            </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Agua de maiz </h3>
                                <h3 class="text-right text-base"> Precio: $73.99 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: Quita la sed, 100% real no fake. </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Jugo de corozo </h3>
                                <h3 class="text-right text-base"> Precio: $1,000,000.99 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: El jugo mas sabroso de este mundo. </h3>
                        </div>

                        <div class="p-4 mb-6">
                            <div class="grid grid-cols-2 text-lg mb-4">
                                <h3 class="text-left"> Chicha de arroz </h3>
                                <h3 class="text-right text-base"> Precio: $10.99 </h3>
                            </div>

                            <h3 class="text-sm text-left"> Descripcion: La hacen los wayuu masticando el maiz, qle
                                diarrea
                                asegurada. </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-10">
                <img src="{{ asset('images/comidaelegante.jpg') }}" alt="Fondo del contenedor"
                    class="w-full h-full object-contain scale-90" />
            </div>

        </div>
    </div>
</body>

</html>