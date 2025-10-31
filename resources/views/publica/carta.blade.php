@extends('components.layouts.main')

@section('title', 'Carta')

@section('content')
    <!-- Sugerencias -->
    <section class="relative py-24 px-6 md:px-16 lg:px-32 text-white overflow-hidden">
        <!-- Fondo difuminado -->
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('images/carta.png') }}" 
                alt="Fondo borroso"
                class="w-full h-full object-cover blur-md scale-105 opacity-90 saturate-125">
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/20 to-black/30"></div>
        </div>



        <!-- Encabezado -->
        <section class="relative flex flex-col items-center text-center py-24 px-6 md:px-20">
            <div class="bg-black/60 backdrop-blur-md rounded-3xl border border-white/10 px-10 py-16 inline-block shadow-lg">
                <h1 class="text-amber-400 text-4xl md:text-6xl lg:text-7xl font-serif mb-6 animate-fade-down">
                    ～ Nuestra Carta ～
                </h1>
                <p class="text-lg md:text-2xl font-serif opacity-90 animate-fade-up">
                    Descubre nuestros deliciosos platos
                </p>
            </div>
        </section>

        <div class="font-serif max-w-6xl mx-auto text-center relative z-10">
            <h2 class="text-amber-400 text-3xl md:text-5xl font-serif mb-16">Sugerencias</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

                <!-- Platos -->
                <div>
                    <div class="p-5 mb-6 bg-black/60 backdrop-blur rounded-xl border border-white/10">
                        <h3 class="text-2xl font-semibold text-amber-400">
                            Platos
                        </h3>
                    </div>

                    @foreach ([ 
                        ['Tequeyoyo', '15.99', 'Plato tradicional hecho con ingredientes frescos y sabrosos.'],
                        ['Arroz con queso', '65.99', 'Cule vaina sabrosa compa.'],
                        ['Tajada con suero', '80.99', 'El suero bien rancio pero potente, manda pal baño.'],
                        ['Yuca con queso', '100.99', 'Yuca y botellon, nutritiva y para donde las burritas.'],
                    ] as [$nombre, $precio, $desc])
                        <div class="p-5 mb-6 bg-black/30 backdrop-blur rounded-xl transition-transform hover:scale-[1.02] duration-300 border border-white/10">
                            <div class="flex justify-between mb-3 text-lg font-semibold">
                                <span>{{ $nombre }}</span>
                                <span class="text-amber-400">${{ $precio }}</span>
                            </div>
                            <p class="text-sm text-left opacity-80">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Bebidas -->
                <div>
                    <div class="p-5 mb-6 bg-black/60 backdrop-blur rounded-xl border border-white/10">
                        <h3 class="text-2xl font-semibold text-amber-400">
                            Bebidas
                        </h3>
                    </div>

                    @foreach ([ 
                        ['Agua de calson', '30.00', 'Para enamorar a cualquier pelagato por ahí.'],
                        ['Agua de maíz', '73.99', 'Quita la sed, 100% real no fake.'],
                        ['Jugo de corozo', '1,000,000.99', 'El jugo más sabroso de este mundo.'],
                        ['Chicha de arroz', '10.99', 'La hacen los wayuu masticando el maíz, qle diarrea asegurada.'],
                    ] as [$nombre, $precio, $desc])
                        <div class="p-5 mb-6 bg-black/30 backdrop-blur rounded-xl transition-transform hover:scale-[1.02] duration-300 border border-white/10">
                            <div class="flex justify-between mb-3 text-lg font-semibold">
                                <span>{{ $nombre }}</span>
                                <span class="text-amber-400">${{ $precio }}</span>
                            </div>
                            <p class="text-sm text-left opacity-80">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>

            </div>

            <!-- Cocteles -->
            <div class="mt-20">
                <div class="p-5 mb-6 bg-black/60 backdrop-blur rounded-xl border border-white/10">
                    <h3 class="text-2xl font-semibold text-amber-400">
                        Cocteles
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ([ 
                        ['Mojito Tropical', '45.00', 'Refrescante bebida con ron y menta.'],
                        ['Margarita de Corozo', '55.99', 'Con el toque especial de la casa.'],
                    ] as [$nombre, $precio, $desc])
                        <div class="p-5 bg-black/30 backdrop-blur rounded-xl transition-transform hover:scale-[1.02] duration-300 border border-white/10">
                            <div class="flex justify-between mb-3 text-lg font-semibold">
                                <span>{{ $nombre }}</span>
                                <span class="text-amber-400">${{ $precio }}</span>
                            </div>
                            <p class="text-sm text-left opacity-80">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    
    <x-scroll-indicator />
@endsection
