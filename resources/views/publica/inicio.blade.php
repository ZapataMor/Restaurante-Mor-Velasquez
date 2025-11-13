@extends('components.layouts.main')

@section('title', 'Inicio')

@section('content')

    <!-- Hero principal -->
    <section class="relative text-center text-white min-h-screen flex items-center justify-center overflow-hidden px-4 py-20 sm:py-32">
        <!-- Imagen de fondo -->
        <img src="{{ asset('images/Restaurante.jpg') }}" 
            alt="Fondo elegante" 
            class="absolute inset-0 w-full h-full object-cover brightness-50">

        <!-- Contenido -->
        <div class="font-serif relative z-10 w-full px-4">
            <div class="bg-black/5 backdrop-blur-lg p-6 sm:p-8 rounded-2xl shadow-lg inline-block max-w-full overflow-x-auto">
                <h1 class="text-[clamp(1.8rem,6vw,4rem)] md:text-[clamp(2.5rem,6vw,5rem)] mb-4 sm:mb-6 tracking-wide leading-tight text-center">
                ∼ Bienvenidos a <span class="text-amber-400">Mor Velasquez ∼</span>
                </h1>


                <p class="text-base sm:text-lg md:text-xl mb-8 sm:mb-10 leading-relaxed font-light text-gray-100">
                    ¡Bienvanido a nuestro restaurante!
                </p>
                <a href="{{ route('reservas.index') }}" 
                class="bg-amber-400 text-black px-6 sm:px-8 py-3 rounded-full hover:bg-amber-600 transition duration-300 inline-block">
                    Reservar ahora
                </a>
            </div>
        </div>
    </section>

    <!-- Sección "El restaurante" -->
    <section class="bg-white py-20 px-6 md:px-12">
        <div class="max-w-7xl mx-auto grid md:grid-cols-[1.2fr_1fr_1.2fr] gap-10 items-center">
            
            <!-- Imagen izquierda -->
            <div class="flex justify-center">
                <img src="{{ asset('images/plato-izquierda.png') }}" 
                    alt="Plato del restaurante"
                    class="w-full max-w-2xl rounded-xl shadow-md object-cover transition-transform duration-500 hover:scale-102">
            </div>

            <!-- Texto central -->
            <div class="text-center font-serif px-4">
                <h2 class="text-3xl md:text-4xl font-semibold text-amber-400 mb-6">El restaurante</h2>
                <p class="text-gray-700 leading-relaxed text-lg">
                    En <span class="font-semibold text-amber-400">Restaurante Mor Velasquez</span>, 
                    nos enorgullece ofrecerte una experiencia culinaria excepcional.  
                    Nuestro menú está cuidadosamente elaborado con ingredientes frescos y de alta calidad 
                    para satisfacer todos los paladares.  
                    Ya sea que busques platos tradicionales o sabores innovadores, nuestro equipo de chefs 
                    talentosos está listo para deleitarte con creaciones únicas.  
                    <br><br>
                    Ven y disfruta de un ambiente acogedor y un servicio impecable.  
                    ¡Te esperamos para compartir momentos inolvidables alrededor de la buena comida!
                </p>
            </div>

            <!-- Imagen derecha -->
            <div class="flex justify-center">
                <img src="{{ asset('images/plato-derecha.png') }}" 
                    alt="Sushi o plato elegante"
                    class="w-full max-w-2xl rounded-xl shadow-md object-cover transition-transform duration-500 hover:scale-102">
            </div>
        </div>
    </section>

    <!-- Sección de Sugerencias -->
    <section class="relative text-white min-h-screen py-20 px-6 md:px-12 overflow-hidden flex items-center">
        <!-- Fondo con la misma imagen, difuminada -->
        <img src="{{ asset('images/comidaelegante.jpg') }}" 
            alt="Fondo elegante difuminado"
            class="absolute inset-0 w-full h-full object-cover scale-110 blur-3xl brightness-50">

        <!-- Capa semitransparente -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- Contenido principal -->
        <div class="font-serif relative z-10 max-w-7xl mx-auto grid md:grid-cols-[1.5fr_1.2fr] gap-12 items-center">
            
            <!-- Lista de sugerencias -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-10 shadow-lg border border-white/10">
                <h2 class="text-4xl md:text-5xl font-serif mb-10 text-center text-amber-400 tracking-wide">
                    Sugerencias del Chef
                </h2>

                <!-- Categorías -->
                <div class="grid md:grid-cols-2 gap-10">
                    <!-- Platos -->
                    <div>
                        <h3 class="text-xl font-semibold text-amber-400 mb-4 text-center border-b border-white/20 pb-2 uppercase">
                            Platos
                        </h3>
                        <ul class="space-y-5 text-gray-100">
                            <li>
                                <p class="font-semibold">Tequeyoyo <span class="float-right text-amber-400">$15.99</span></p>
                                <p class="text-sm text-gray-300">Plato tradicional hecho con ingredientes frescos y sabrosos.</p>
                            </li>
                            <li>
                                <p class="font-semibold">Arroz con queso <span class="float-right text-amber-400">$65.99</span></p>
                                <p class="text-sm text-gray-300">Cremoso y delicioso, una joya de la casa.</p>
                            </li>
                            <li>
                                <p class="font-semibold">Tajada con suero <span class="float-right text-amber-400">$80.99</span></p>
                                <p class="text-sm text-gray-300">Un clásico costeño con toque gourmet.</p>
                            </li>
                            <li>
                                <p class="font-semibold">Yuca con queso <span class="float-right text-amber-400">$100.99</span></p>
                                <p class="text-sm text-gray-300">Dorada, crocante y con el toque justo de sabor.</p>
                            </li>
                        </ul>
                    </div>

                    <!-- Bebidas -->
                    <div>
                        <h3 class="text-xl font-semibold text-amber-400 mb-4 text-center border-b border-white/20 pb-2 uppercase">
                            Bebidas
                        </h3>
                        <ul class="space-y-5 text-gray-100">
                            <li>
                                <p class="font-semibold">Agua de calson <span class="float-right text-amber-400">$30.00</span></p>
                                <p class="text-sm text-gray-300">Refrescante y única, preparada artesanalmente.</p>
                            </li>
                            <li>
                                <p class="font-semibold">Agua de maíz <span class="float-right text-amber-400">$73.99</span></p>
                                <p class="text-sm text-gray-300">Natural, ligera y perfecta para acompañar tus platos.</p>
                            </li>
                            <li>
                                <p class="font-semibold">Jugo de corozo <span class="float-right text-amber-400">$25.99</span></p>
                                <p class="text-sm text-gray-300">El sabor caribeño que no puede faltar.</p>
                            </li>
                            <li>
                                <p class="font-semibold">Chicha de arroz <span class="float-right text-amber-400">$10.99</span></p>
                                <p class="text-sm text-gray-300">Tradicional, dulce y con aroma a hogar.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Imagen lateral más ancha y alta -->
            <div class="hidden md:flex justify-center items-center">
                <img src="{{ asset('images/comidaelegante.jpg') }}" 
                    alt="Mesa elegante"
                    class="w-[110%] h-[90vh] object-cover rounded-2xl shadow-xl border border-white/10">
            </div>
        </div>
    </section>

    <!-- Sección de valores -->
    <section class="bg-neutral-50 py-20 px-6 md:px-12">
        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-10">
            <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-8 text-center border-t-4 border-amber-600">
                <h3 class="font-serif text-2xl text-amber-400 mb-4">Cocina Tradicional</h3>
                <p class="text-gray-600 leading-relaxed">
                    Sabores auténticos elaborados con ingredientes frescos, seleccionados cuidadosamente
                    por nuestros chefs expertos.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-8 text-center border-t-4 border-amber-500">
                <h3 class="font-serif text-2xl text-amber-400 mb-4">Ambiente Sofisticado</h3>
                <p class="text-gray-600 leading-relaxed">
                    Disfruta un entorno cálido, con detalles pensados para hacer de cada visita
                    una experiencia memorable.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-8 text-center border-t-4 border-amber-400">
                <h3 class="font-serif text-2xl text-amber-400 mb-4">Reservas Online</h3>
                <p class="text-gray-600 leading-relaxed">
                    Agenda tu mesa de manera rápida y sencilla. Tu próxima velada está a un clic de distancia.
                </p>
            </div>
        </div>
    </section>

    <!-- Sección final (frase elegante) -->
    <section class="bg-gradient-to-r from-amber-600 to-amber-400 text-white py-16 text-center">
        <h2 class="text-3xl md:text-4xl font-serif font-semibold mb-4">Sabores que cuentan historias</h2>
        <p class="text-lg md:text-xl font-light max-w-3xl mx-auto leading-relaxed">
            En Mor Velasquez creemos que cada plato tiene una historia, y cada historia merece ser servida con pasión.
        </p>
    </section>

    <x-scroll-indicator />
@endsection
