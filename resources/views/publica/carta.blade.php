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

        @php
            // Agrupamos productos por categoría
            $grupos = $products->groupBy('category');
        @endphp

        <div class="font-serif max-w-6xl mx-auto text-center relative z-10">
            <h2 class="text-amber-400 text-3xl md:text-5xl font-serif mb-16">Sugerencias</h2>

            @foreach ($grupos as $categoria => $items)
                <!-- Título de categoría -->
                <div class="p-5 mb-6 bg-black/60 backdrop-blur rounded-xl border border-white/10">
                    <h3 class="text-2xl font-semibold text-amber-400">
                        {{ $categoria }}
                    </h3>
                </div>

                <!-- Lista de productos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                    @foreach ($items as $item)
                        <div class="p-5 bg-black/30 backdrop-blur rounded-xl transition-transform hover:scale-[1.02] duration-300 border border-white/10">
                            <div class="flex justify-between mb-3 text-lg font-semibold">
                                <span>{{ $item->name }}</span>
                                <span class="text-amber-400">${{ number_format($item->price, 2) }}</span>
                            </div>

                            <p class="text-sm text-left opacity-80">{{ $item->description }}</p>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>
    </section>

    <x-scroll-indicator />
@endsection
