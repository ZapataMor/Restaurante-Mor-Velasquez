@extends('components.layouts.main')

@section('title', 'Contacto - Mor Velasquez')

@section('content')

    <!-- Hero principal con parallax -->
    <section class="relative text-center text-white min-h-[85vh] flex items-center justify-center overflow-hidden">
        <!-- Imagen de fondo con efecto parallax -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/60">
            <img src="{{ asset('images/contacto-fondo.jpg') }}" 
                alt="Ambiente elegante de Mor Velasquez" 
                class="w-full h-full object-cover opacity-90"
                loading="eager">
        </div>

        <!-- Contenido hero -->
        <div class="relative z-10 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-black/20 backdrop-blur-xl p-8 sm:p-12 lg:p-16 rounded-3xl shadow-2xl border border-white/10">
                <span class="inline-block text-amber-400 text-sm sm:text-base font-light tracking-[0.3em] uppercase mb-4 animate-fade-in">
                    Estamos para servirte
                </span>
                
                <h1 class="font-serif text-4xl sm:text-5xl lg:text-7xl mb-6 tracking-tight leading-tight">
                    Contáctanos en<br>
                    <span class="text-amber-400 inline-block mt-2">Mor Velasquez</span>
                </h1>

                <p class="text-base sm:text-lg lg:text-xl mb-8 leading-relaxed font-light text-gray-100 max-w-3xl mx-auto">
                    Estamos aquí para responder tus dudas, recibir tus comentarios o ayudarte a crear momentos inolvidables.
                </p>

                <!-- Botones de acción rápida -->
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="tel:+571234567890" 
                       class="group bg-amber-500 hover:bg-amber-600 text-white px-8 py-4 rounded-full font-medium transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Llamar ahora
                    </a>
                    <a href="#formulario" 
                       class="group bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-full font-medium transition-all duration-300 backdrop-blur-md border border-white/20 hover:border-white/40 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Enviar mensaje
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Información de contacto y formulario -->
    <section id="formulario" class="bg-gradient-to-b from-gray-50 to-white py-20 lg:py-28 px-6">
        <div class="max-w-7xl mx-auto">
            
            <!-- Título de sección -->
            <div class="text-center mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-900 mb-4">
                    Conéctate con nosotros
                </h2>
                <div class="w-24 h-1 bg-amber-400 mx-auto rounded-full"></div>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">
                
                <!-- Información del restaurante -->
                <div class="space-y-8">
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                        <h3 class="font-serif text-2xl font-semibold text-amber-600 mb-6 flex items-center gap-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Nuestra Información
                        </h3>
                        
                        <div class="space-y-5 text-gray-700">
                            <!-- Dirección -->
                            <div class="flex items-start gap-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 mb-1">Dirección</p>
                                    <p class="leading-relaxed">Calle 123 #45-67<br>Bogotá D.C., Colombia</p>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="flex items-start gap-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 mb-1">Teléfono</p>
                                    <a href="tel:+571234567890" class="text-amber-600 hover:text-amber-700 hover:underline">
                                        +57 123 456 7890
                                    </a>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start gap-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 mb-1">Email</p>
                                    <a href="mailto:contacto@morvelasquez.com" class="text-amber-600 hover:text-amber-700 hover:underline">
                                        contacto@morvelasquez.com
                                    </a>
                                </div>
                            </div>

                            <!-- Horario -->
                            <div class="flex items-start gap-4 group">
                                <div class="flex-shrink-0 w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 mb-1">Horario de atención</p>
                                    <p class="leading-relaxed">Lunes a Domingo<br>10:00 AM - 10:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Redes sociales -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100/50 p-8 rounded-2xl border border-amber-200">
                        <h3 class="font-serif text-xl font-semibold text-gray-900 mb-4">Síguenos en redes sociales</h3>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            Mantente al día con nuestras novedades, promociones especiales y eventos exclusivos.
                        </p>
                        <div class="flex gap-4">
                            <a href="#" class="group w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md hover:shadow-lg hover:scale-110 transition-all duration-300">
                                <svg class="w-5 h-5 text-gray-700 group-hover:text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="group w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md hover:shadow-lg hover:scale-110 transition-all duration-300">
                                <svg class="w-5 h-5 text-gray-700 group-hover:text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="#" class="group w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md hover:shadow-lg hover:scale-110 transition-all duration-300">
                                <svg class="w-5 h-5 text-gray-700 group-hover:text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mapa de ubicación (opcional) -->
    <section class="bg-gray-100 py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-gray-900 mb-4">
                    Encuéntranos
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Visítanos en nuestro restaurante y vive una experiencia culinaria única
                </p>
            </div>
            
            <!-- Aquí puedes integrar Google Maps -->
            <div class="rounded-2xl overflow-hidden shadow-xl h-96 bg-gray-200 flex items-center justify-center">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.8050558806746!2d-74.07209688523654!3d4.624335596626424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9bfd2da6cb29%3A0x239d635520a33914!2zQm9nb3TDoQ!5e0!3m2!1ses!2sco!4v1234567890123!5m2!1ses!2sco" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-full">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Sección final con CTA -->
    <section class="relative bg-gradient-to-br from-amber-600 via-amber-500 to-amber-400 text-white py-20 lg:py-24 overflow-hidden">
        <!-- Patrón decorativo de fondo -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <div class="relative z-10 max-w-4xl mx-auto text-center px-6">
            <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-semibold mb-6 leading-tight">
                Siempre cerca de ti
            </h2>
            <div class="w-24 h-1 bg-white/50 mx-auto rounded-full mb-8"></div>
            <p class="text-lg sm:text-xl lg:text-2xl font-light leading-relaxed mb-10 text-white/95">
                En Mor Velasquez queremos que cada experiencia sea inolvidable. Contáctanos y deja que la buena comida nos conecte.
            </p>
            <a href="#formulario" 
               class="inline-flex items-center gap-2 bg-white text-amber-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                Reserva tu mesa
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </section>

    <x-scroll-indicator />

@endsection