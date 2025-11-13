<nav class="font-serif fixed top-0 left-0 w-full bg-black/30 backdrop-blur-lg shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('inicio') }}" class="text-2xl text-white tracking-wide">
            Restaurante <span class="text-amber-400">Mor Velasquez</span>
        </a>

        <!-- Botón menú móvil -->
        <button id="menu-btn" class="md:hidden focus:outline-none text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Menú escritorio -->
        <ul class="hidden md:flex space-x-8 text-white font-medium">
            <li><a href="{{ route('inicio') }}" class="hover:text-amber-400 transition">Inicio</a></li>
            <li><a href="{{ route('carta') }}" class="hover:text-amber-400 transition">Carta</a></li>
            <li><a href="{{ route('reservas.index') }}" class="hover:text-amber-400 transition">Reservas</a></li>
            <li><a href="{{ route('contacto') }}" class="hover:text-amber-400 transition">Contacto</a></li>
        </ul>
    </div>

    <!-- Menú móvil -->
    <div id="mobile-menu" class="hidden md:hidden bg-black/70 backdrop-blur-lg text-white border-t border-white/10">
        <ul class="flex flex-col text-center py-4 space-y-2">
            <li><a href="{{ route('inicio') }}" class="block py-2 hover:text-amber-400 transition">Inicio</a></li>
            <li><a href="{{ route('carta') }}" class="block py-2 hover:text-amber-400 transition">Carta</a></li>
            <li><a href="{{ route('reservas.index') }}" class="block py-2 hover:text-amber-400 transition">Reservas</a></li>
            <li><a href="{{ route('contacto') }}" class="block py-2 hover:text-amber-400 transition">Contacto</a></li>
        </ul>
    </div>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
    </script>
</nav>
