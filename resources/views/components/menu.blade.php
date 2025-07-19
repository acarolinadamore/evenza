<nav class="bg-gray-900 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
                <a href="{{ route('site') }}" class="flex items-center text-white text-2xl font-bold">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Evenza
                </a>
            <div class="hidden md:flex space-x-6">
                <a href="/painel" class="text-white hover:text-yellow-400 transition-colors font-medium flex items-center">
                    <i class="fas fa-tachometer-alt mr-2"></i> Painel
                </a>
                <a href="/eventos" class="text-white hover:text-yellow-400 transition-colors font-medium flex items-center">
                    <i class="fas fa-calendar mr-2"></i> Eventos
                </a>
                <a href="/participantes" class="text-white hover:text-yellow-400 transition-colors font-medium flex items-center">
                    <i class="fas fa-users mr-2"></i> Participantes
                </a>
            </div>

            <div class="md:hidden">
                <button id="menu-mobile" class="text-white text-xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <div id="menu-mobile-conteudo" class="hidden md:hidden pb-4 space-y-2">
            <a href="/painel" class="block text-white py-2 hover:text-yellow-400 transition-colors">
                <i class="fas fa-tachometer-alt mr-2"></i> Painel
            </a>
            <a href="/eventos" class="block text-white py-2 hover:text-yellow-400 transition-colors">
                <i class="fas fa-calendar mr-2"></i> Eventos
            </a>
            <a href="/participantes" class="block text-white py-2 hover:text-yellow-400 transition-colors">
                <i class="fas fa-users mr-2"></i> Participantes
            </a>
        </div>
    </div>
</nav>