<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $evento->nome }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @if($evento->tema)
    <style>
        :root {
            --cor-principal: {{ $evento->tema->cor_principal ?? '#1a1a1a' }};
            --cor-destaque: {{ $evento->tema->cor_destaque ?? '#ad8741' }};
        }

        .bg-principal { background-color: var(--cor-principal); }
        .bg-destaque { background-color: var(--cor-destaque); }
        .text-principal { color: var(--cor-principal); }
        .text-destaque { color: var(--cor-destaque); }
        .border-destaque { border-color: var(--cor-destaque); }
        .hover\:bg-destaque:hover { background-color: var(--cor-destaque); }

        @if($evento->tema->imagem_fundo)
        .hero-section {
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('storage/' . $evento->tema->imagem_fundo) }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        @endif
    </style>
    @endif
</head>
<body class="bg-gray-50" x-data="{
    copiarLink() {
        navigator.clipboard.writeText(window.location.href);
        this.$refs.copyToast.classList.remove('hidden');
        setTimeout(() => this.$refs.copyToast.classList.add('hidden'), 3000);
    }
}">
    <!-- Toast de cópia -->
    <div x-ref="copyToast" class="hidden fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <i class="fas fa-check-circle mr-2"></i>Link copiado!
    </div>

    <!-- Toast de notificações -->
    @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"
         x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 4000)">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"
         x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 4000)">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
    @endif

    <!-- Header com Logo -->
    @if($evento->tema && $evento->tema->logo)
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <img src="{{ asset('storage/' . $evento->tema->logo) }}" alt="{{ $evento->nome }}" class="h-12">
            <button @click="copiarLink()" class="text-sm bg-destaque text-white px-4 py-2 rounded-lg hover:opacity-90">
                <i class="fas fa-link mr-2"></i>Copiar Link
            </button>
        </div>
    </header>
    @endif

    <!-- Blocos de Conteúdo -->
    @foreach($evento->blocos as $bloco)
        @if($bloco->tipo === 'hero')
            <section class="hero-section bg-principal text-white py-24">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto text-center">
                        <h1 class="text-5xl md:text-6xl font-bold mb-4">{{ $evento->nome }}</h1>
                        @if($bloco->conteudo && isset($bloco->conteudo['subtitulo']))
                        <p class="text-xl md:text-2xl mb-8 opacity-90">{{ $bloco->conteudo['subtitulo'] }}</p>
                        @endif

                        <div class="flex flex-wrap justify-center gap-6 mt-12">
                            @if($evento->data_evento)
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-4">
                                <i class="fas fa-calendar-alt text-2xl mb-2"></i>
                                <p class="text-sm opacity-75">Data</p>
                                <p class="text-lg font-bold">{{ date('d/m/Y', strtotime($evento->data_evento)) }}</p>
                            </div>
                            @endif

                            @if($evento->local)
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-4">
                                <i class="fas fa-map-marker-alt text-2xl mb-2"></i>
                                <p class="text-sm opacity-75">Local</p>
                                <p class="text-lg font-bold">{{ $evento->local }}</p>
                            </div>
                            @endif

                            @if($evento->valor_ingresso)
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-4">
                                <i class="fas fa-ticket-alt text-2xl mb-2"></i>
                                <p class="text-sm opacity-75">Ingresso</p>
                                <p class="text-lg font-bold">R$ {{ number_format($evento->valor_ingresso, 2, ',', '.') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

        @elseif($bloco->tipo === 'descricao')
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        @if($bloco->conteudo && isset($bloco->conteudo['titulo']))
                        <h2 class="text-4xl font-bold text-principal mb-8 text-center">{{ $bloco->conteudo['titulo'] }}</h2>
                        @endif

                        @if($bloco->conteudo && isset($bloco->conteudo['texto']))
                        <div class="prose max-w-none text-gray-700 text-lg leading-relaxed">
                            {!! nl2br(e($bloco->conteudo['texto'])) !!}
                        </div>
                        @endif
                    </div>
                </div>
            </section>

        @elseif($bloco->tipo === 'agenda')
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        <h2 class="text-4xl font-bold text-principal mb-12 text-center">Agenda do Evento</h2>

                        @if($bloco->conteudo && isset($bloco->conteudo['itens']))
                        <div class="space-y-6">
                            @foreach($bloco->conteudo['itens'] as $item)
                            <div class="bg-white rounded-lg p-6 shadow-sm border-l-4 border-destaque">
                                <div class="flex items-start gap-4">
                                    <div class="bg-destaque text-white px-4 py-2 rounded-lg font-bold">
                                        {{ $item['horario'] ?? '' }}
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-principal mb-2">{{ $item['titulo'] ?? '' }}</h3>
                                        @if(isset($item['descricao']))
                                        <p class="text-gray-600">{{ $item['descricao'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </section>

        @elseif($bloco->tipo === 'banner')
            @if($bloco->conteudo && isset($bloco->conteudo['imagens']))
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    @foreach($bloco->conteudo['imagens'] as $imagem)
                    <img src="{{ asset('storage/' . $imagem) }}" alt="Banner" class="w-full max-w-5xl mx-auto rounded-lg shadow-lg">
                    @endforeach
                </div>
            </section>
            @endif

        @elseif($bloco->tipo === 'mapa')
            @if($bloco->conteudo && isset($bloco->conteudo['iframe']))
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        <h2 class="text-4xl font-bold text-principal mb-8 text-center">Localização</h2>
                        <div class="aspect-video rounded-lg overflow-hidden shadow-lg">
                            {!! $bloco->conteudo['iframe'] !!}
                        </div>
                    </div>
                </div>
            </section>
            @endif

        @elseif($bloco->tipo === 'galeria')
            @if($bloco->conteudo && isset($bloco->conteudo['imagens']))
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <div class="max-w-6xl mx-auto">
                        <h2 class="text-4xl font-bold text-principal mb-12 text-center">Galeria</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($bloco->conteudo['imagens'] as $imagem)
                            <div class="aspect-square rounded-lg overflow-hidden shadow-lg">
                                <img src="{{ asset('storage/' . $imagem) }}" alt="Galeria" class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            @endif
        @endif
    @endforeach

    <!-- Formulários Dinâmicos -->
    @foreach($evento->formularios as $formulario)
    <section class="py-16 @if($loop->even) bg-gray-50 @else bg-white @endif">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-principal mb-6 text-center">{{ $formulario->nome }}</h2>

                    <form action="{{ route('landing-page.formulario.submit', [$evento->slug, $formulario->slug]) }}"
                          method="POST"
                          class="space-y-6">
                        @csrf

                        @foreach($formulario->campos as $campo)
                            @if($campo->tipo === 'mensagem')
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                    <p class="text-gray-700">{{ $campo->label }}</p>
                                </div>

                            @elseif($campo->tipo === 'nome' || $campo->tipo === 'email' || $campo->tipo === 'telefone')
                                <div>
                                    <label for="campo_{{ $campo->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $campo->label }} @if($campo->obrigatorio)<span class="text-red-500">*</span>@endif
                                    </label>
                                    <input type="{{ $campo->tipo === 'email' ? 'email' : 'text' }}"
                                           id="campo_{{ $campo->id }}"
                                           name="campo_{{ $campo->id }}"
                                           @if($campo->obrigatorio) required @endif
                                           placeholder="{{ $campo->placeholder }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-destaque focus:border-transparent">
                                    @error("campo_{$campo->id}")
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            @elseif($campo->tipo === 'textarea')
                                <div>
                                    <label for="campo_{{ $campo->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $campo->label }} @if($campo->obrigatorio)<span class="text-red-500">*</span>@endif
                                    </label>
                                    <textarea id="campo_{{ $campo->id }}"
                                              name="campo_{{ $campo->id }}"
                                              rows="4"
                                              @if($campo->obrigatorio) required @endif
                                              placeholder="{{ $campo->placeholder }}"
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-destaque focus:border-transparent"></textarea>
                                    @error("campo_{$campo->id}")
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            @elseif($campo->tipo === 'select')
                                <div>
                                    <label for="campo_{{ $campo->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $campo->label }} @if($campo->obrigatorio)<span class="text-red-500">*</span>@endif
                                    </label>
                                    <select id="campo_{{ $campo->id }}"
                                            name="campo_{{ $campo->id }}"
                                            @if($campo->obrigatorio) required @endif
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-destaque focus:border-transparent">
                                        <option value="">Selecione...</option>
                                        @if($campo->opcoes)
                                            @foreach($campo->opcoes as $opcao)
                                            <option value="{{ $opcao }}">{{ $opcao }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error("campo_{$campo->id}")
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            @elseif($campo->tipo === 'radio')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $campo->label }} @if($campo->obrigatorio)<span class="text-red-500">*</span>@endif
                                    </label>
                                    <div class="space-y-2">
                                        @if($campo->opcoes)
                                            @foreach($campo->opcoes as $opcao)
                                            <label class="flex items-center">
                                                <input type="radio"
                                                       name="campo_{{ $campo->id }}"
                                                       value="{{ $opcao }}"
                                                       @if($campo->obrigatorio) required @endif
                                                       class="w-4 h-4 text-destaque focus:ring-destaque">
                                                <span class="ml-2 text-gray-700">{{ $opcao }}</span>
                                            </label>
                                            @endforeach
                                        @endif
                                    </div>
                                    @error("campo_{$campo->id}")
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            @elseif($campo->tipo === 'checkbox')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $campo->label }} @if($campo->obrigatorio)<span class="text-red-500">*</span>@endif
                                    </label>
                                    <div class="space-y-2">
                                        @if($campo->opcoes)
                                            @foreach($campo->opcoes as $opcao)
                                            <label class="flex items-center">
                                                <input type="checkbox"
                                                       name="campo_{{ $campo->id }}[]"
                                                       value="{{ $opcao }}"
                                                       class="w-4 h-4 text-destaque rounded focus:ring-destaque">
                                                <span class="ml-2 text-gray-700">{{ $opcao }}</span>
                                            </label>
                                            @endforeach
                                        @endif
                                    </div>
                                    @error("campo_{$campo->id}")
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        @endforeach

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-destaque text-white px-6 py-3 rounded-lg font-medium hover:opacity-90 transition-opacity">
                                <i class="fas fa-paper-plane mr-2"></i>Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @endforeach

    <!-- Botão de Compartilhamento WhatsApp -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="https://web.whatsapp.com/send?text={{ urlencode('Confira este evento: ' . url('/' . $evento->slug)) }}"
           target="_blank"
           class="bg-green-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition-colors">
            <i class="fab fa-whatsapp text-2xl"></i>
        </a>
    </div>

    <!-- Footer -->
    <footer class="bg-principal text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} {{ $evento->nome }}</p>
            <p class="text-sm opacity-75 mt-2">Desenvolvido com Evenza</p>
        </div>
    </footer>
</body>
</html>
