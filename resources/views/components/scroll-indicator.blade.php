<div id="scroll-indicator" 
     class="fixed bottom-6 right-6 z-50 flex items-center justify-center transition-opacity duration-500 opacity-100">
    <div class="relative group">
        <!-- Burbuja -->
        <div class="bg-black/50 rounded-full p-2 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" 
                class="w-6 h-6 text-white animate-bounce" 
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </div>


        <!-- Tooltip -->
        <div class="absolute select-none right-full mr-3 top-1/2 -translate-y-1/2 bg-black/70 text-white text-sm rounded-xl px-3 py-1 opacity-0 group-hover:opacity-100 transition duration-300 whitespace-nowrap">
            Desliza hacia abajo
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const indicator = document.getElementById('scroll-indicator');

    const toggleVisibility = () => {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const maxScroll = document.documentElement.scrollHeight - window.innerHeight;

        // Si estamos en el 90% del final, ocultamos la flecha
        if (scrollTop >= maxScroll * 0.9) {
            indicator.classList.add('opacity-0');
            indicator.classList.remove('opacity-100');
        } else {
            indicator.classList.remove('opacity-0');
            indicator.classList.add('opacity-100');
        }
    };

    window.addEventListener('scroll', toggleVisibility);
    toggleVisibility();
});
</script>
