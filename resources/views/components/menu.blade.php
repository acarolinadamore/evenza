<nav class="bg-gray-900 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a href="{{ route('site') }}" class="flex items-center text-white text-2xl font-bold">
                <i class="fas fa-calendar-check mr-2"></i>
                Evenza
            </a>

            @auth
            <!-- Center Navigation -->
            <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 space-x-10">
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

            <!-- Right Side Navigation -->
            <div class="hidden md:flex space-x-6 items-center">
                @if(auth()->user()->isAdmin())
                <!-- Admin Dropdown -->
                <div x-data="{ open: false }" @click.away="open = false" class="relative">
                    <button @click="open = !open" class="bg-gradient-to-r from-purple-600 to-red-600 hover:from-purple-700 hover:to-red-700 px-4 py-2 rounded-lg text-white font-medium inline-flex items-center transition-all">
                        <i class="fas fa-shield-alt mr-2 text-sm"></i>
                        <span>Administração</span>
                        <i class="fas fa-chevron-down ml-2 text-xs" :class="{'rotate-180': open}"></i>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50"
                         style="display: none;">
                        <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-purple-50 transition-colors">
                            <i class="fas fa-users-cog mr-2 text-purple-600"></i> Usuários
                        </a>
                    </div>
                </div>
                @endif

                <!-- User Dropdown -->
                <div x-data="{ open: false }" @click.away="open = false" class="relative">
                    <button @click="open = !open" class="text-white hover:text-yellow-400 transition-colors font-medium flex items-center">
                        {{ auth()->user()->name }}
                        <i class="fas fa-chevron-down ml-2 text-xs" :class="{'rotate-180': open}"></i>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50"
                         style="display: none;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i> Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <div class="hidden md:flex space-x-4">
                <a href="{{ route('login') }}" class="text-white hover:text-yellow-400 transition-colors font-medium flex items-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Entrar
                </a>
            </div>
            @endauth

            <div class="md:hidden">
                <button id="menu-mobile" class="text-white text-xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <div id="menu-mobile-conteudo" class="hidden md:hidden pb-4 space-y-2">
            @auth
            <a href="/painel" class="block text-white py-2 hover:text-yellow-400 transition-colors">
                <i class="fas fa-tachometer-alt mr-2"></i> Painel
            </a>
            <a href="/eventos" class="block text-white py-2 hover:text-yellow-400 transition-colors">
                <i class="fas fa-calendar mr-2"></i> Eventos
            </a>
            <a href="/participantes" class="block text-white py-2 hover:text-yellow-400 transition-colors">
                <i class="fas fa-users mr-2"></i> Participantes
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.users.index') }}" class="block text-purple-300 py-2 hover:text-purple-100 transition-colors font-medium">
                <i class="fas fa-shield-alt mr-2"></i> Administração
            </a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left block text-white py-2 hover:text-yellow-400 transition-colors">
                    <i class="fas fa-sign-out-alt mr-2"></i> Sair
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="block text-white py-2 hover:text-yellow-400 transition-colors">
                <i class="fas fa-sign-in-alt mr-2"></i> Entrar
            </a>
            @endauth
        </div>
    </div>
</nav>