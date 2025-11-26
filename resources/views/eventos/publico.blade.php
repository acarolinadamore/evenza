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

        /* Estilos para modo de edição */
        .edit-mode .bloco-secao {
            position: relative;
            cursor: move;
            transition: all 0.3s ease;
        }

        .edit-mode .bloco-secao:hover {
            outline: 3px dashed #3b82f6;
            outline-offset: 4px;
        }

        .edit-mode .bloco-handle {
            display: flex !important;
        }

        .edit-mode .component-handle {
            display: inline-block !important;
        }

        .edit-mode .hero-component {
            cursor: move;
            padding: 12px;
            border: 2px dashed transparent;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .edit-mode .hero-component:hover {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.05);
        }

        .hero-component.sortable-ghost {
            opacity: 0.4;
        }

        .bloco-handle {
            display: none;
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(59, 130, 246, 0.95);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            z-index: 10;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        .sortable-ghost {
            opacity: 0.4;
            background: #e0e7ff;
        }

        .sortable-drag {
            opacity: 0.8;
        }
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

    <!-- Botão de Modo de Edição (Flutuante) -->
    <button id="toggleEditMode"
            class="fixed bottom-24 left-6 bg-blue-600 text-white w-14 h-14 rounded-full shadow-lg hover:bg-blue-700 transition-all z-50 flex items-center justify-center"
            onclick="toggleEditMode()"
            title="Ativar modo de edição">
        <i class="fas fa-edit text-xl"></i>
    </button>

    <!-- Container de Blocos (para drag and drop) -->
    <div id="blocos-container">
    <!-- Blocos de Conteúdo -->
    @foreach($evento->blocos as $bloco)
        @if($bloco->tipo === 'hero')
            @php
                $heroStyle = 'background-color: var(--cor-principal);';
                if($bloco->conteudo && isset($bloco->conteudo['imagem_fundo'])) {
                    $heroStyle = "background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('" . asset('storage/' . $bloco->conteudo['imagem_fundo']) . "'); background-size: cover; background-position: center;";
                }

                // Ordem padrão dos componentes
                $ordem = $bloco->conteudo['ordem_componentes'] ?? ['titulo', 'subtitulo', 'imagem', 'cards'];
            @endphp
            <section class="bloco-secao text-white py-24 relative" data-bloco-id="{{ $bloco->id }}" style="{{ $heroStyle }}">
                <div class="bloco-handle">
                    <i class="fas fa-grip-vertical"></i>
                    <span>Arrastar</span>
                </div>

                <div class="container mx-auto px-4 relative z-20">
                    <div class="max-w-4xl mx-auto text-center">
                        <div id="hero-components-{{ $bloco->id }}" class="space-y-6">
                            @foreach($ordem as $componente)
                                @if($componente === 'titulo')
                                    <div class="hero-component" data-component="titulo">
                                        <div class="component-handle hidden bg-blue-600 text-white text-xs px-3 py-1 rounded mb-2 inline-block cursor-move">
                                            <i class="fas fa-grip-vertical mr-1"></i>Título
                                        </div>
                                        <h1 class="text-5xl md:text-6xl font-bold">{{ $evento->nome }}</h1>
                                    </div>
                                @elseif($componente === 'subtitulo' && $bloco->conteudo && isset($bloco->conteudo['subtitulo']))
                                    <div class="hero-component" data-component="subtitulo">
                                        <div class="component-handle hidden bg-blue-600 text-white text-xs px-3 py-1 rounded mb-2 inline-block cursor-move">
                                            <i class="fas fa-grip-vertical mr-1"></i>Subtítulo
                                        </div>
                                        <p class="text-xl md:text-2xl opacity-90">{{ $bloco->conteudo['subtitulo'] }}</p>
                                    </div>
                                @elseif($componente === 'imagem' && $bloco->conteudo && isset($bloco->conteudo['imagem']))
                                    <div class="hero-component flex justify-center" data-component="imagem">
                                        <div>
                                            <div class="component-handle hidden bg-blue-600 text-white text-xs px-3 py-1 rounded mb-2 inline-block cursor-move">
                                                <i class="fas fa-grip-vertical mr-1"></i>Imagem
                                            </div>
                                            <img src="{{ asset('storage/' . $bloco->conteudo['imagem']) }}"
                                                 alt="Imagem"
                                                 class="max-w-xs rounded-lg shadow-2xl mx-auto">
                                        </div>
                                    </div>
                                @elseif($componente === 'cards')
                                    <div class="hero-component" data-component="cards">
                                        <div class="component-handle hidden bg-blue-600 text-white text-xs px-3 py-1 rounded mb-2 inline-block cursor-move">
                                            <i class="fas fa-grip-vertical mr-1"></i>Informações
                                        </div>
                                        <div class="flex flex-wrap justify-center gap-6 max-w-6xl mx-auto">
                                            @if($evento->data_evento)
                                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-4 text-center w-full sm:w-auto sm:min-w-[200px]">
                                                <i class="fas fa-calendar-alt text-2xl mb-2"></i>
                                                <p class="text-sm opacity-75">Data</p>
                                                <p class="text-lg font-bold">{{ date('d/m/Y', strtotime($evento->data_evento)) }}</p>
                                            </div>
                                            @endif

                                            @if($evento->hora_evento)
                                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-4 text-center w-full sm:w-auto sm:min-w-[200px]">
                                                <i class="fas fa-clock text-2xl mb-2"></i>
                                                <p class="text-sm opacity-75">Hora</p>
                                                <p class="text-lg font-bold">{{ date('H:i', strtotime($evento->hora_evento)) }}</p>
                                            </div>
                                            @endif

                                            @if($evento->local || $evento->endereco)
                                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-4 text-center w-full sm:w-auto sm:min-w-[200px]">
                                                <i class="fas fa-map-marker-alt text-2xl mb-2"></i>
                                                <p class="text-sm opacity-75">Local</p>
                                                <p class="text-lg font-bold">
                                                    @if($evento->local && $evento->endereco)
                                                        {{ $evento->local }}<br><span class="text-sm opacity-75">{{ $evento->endereco }}</span>
                                                    @elseif($evento->local)
                                                        {{ $evento->local }}
                                                    @else
                                                        {{ $evento->endereco }}
                                                    @endif
                                                </p>
                                            </div>
                                            @endif

                                            @if($evento->valor_ingresso)
                                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-4 text-center w-full sm:w-auto sm:min-w-[200px]">
                                                <i class="fas fa-ticket-alt text-2xl mb-2"></i>
                                                <p class="text-sm opacity-75">Ingresso</p>
                                                <p class="text-lg font-bold">R$ {{ number_format($evento->valor_ingresso, 2, ',', '.') }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

        @elseif($bloco->tipo === 'descricao')
            <section class="bloco-secao py-16 bg-white" data-bloco-id="{{ $bloco->id }}">
                <div class="bloco-handle">
                    <i class="fas fa-grip-vertical"></i>
                    <span>Arrastar</span>
                </div>
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
            @php
                $altura = $bloco->conteudo['altura'] ?? 500;
            @endphp
            <section class="bloco-secao bg-white" data-bloco-id="{{ $bloco->id }}">
                <div class="bloco-handle">
                    <i class="fas fa-grip-vertical"></i>
                    <span>Arrastar</span>
                </div>
                @foreach($bloco->conteudo['imagens'] as $imagem)
                <div style="height: {{ $altura }}px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $imagem) }}" alt="Banner" class="w-full h-full object-cover">
                </div>
                @endforeach
            </section>
            @endif

        @elseif($bloco->tipo === 'mapa')
            @if($bloco->conteudo && isset($bloco->conteudo['iframe']))
            <section class="bloco-secao py-16 bg-gray-50" data-bloco-id="{{ $bloco->id }}">
                <div class="bloco-handle">
                    <i class="fas fa-grip-vertical"></i>
                    <span>Arrastar</span>
                </div>
                <div class="w-full">
                    <h2 class="text-4xl font-bold text-principal mb-8 text-center">Localização</h2>
                    <div class="aspect-video overflow-hidden shadow-lg">
                        {!! $bloco->conteudo['iframe'] !!}
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
    @php
        $sectionStyle = '';
        if ($formulario->background_cor) {
            $sectionStyle .= "background-color: {$formulario->background_cor};";
        }
        if ($formulario->background_imagem) {
            $sectionStyle .= " background-image: url('" . asset('storage/' . $formulario->background_imagem) . "'); background-size: cover; background-position: center;";
        }
    @endphp
    <section class="bloco-secao py-16 {{ !$formulario->background_cor && !$formulario->background_imagem ? ($loop->even ? 'bg-gray-50' : 'bg-white') : '' }}" data-formulario-id="{{ $formulario->id }}" @if($sectionStyle) style="{{ $sectionStyle }}" @endif>
        <div class="bloco-handle" style="background: rgba(168, 85, 247, 0.95);">
            <i class="fas fa-grip-vertical"></i>
            <span>Arrastar Formulário</span>
        </div>
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

                            @elseif($campo->tipo === 'texto' || $campo->tipo === 'nome' || $campo->tipo === 'email' || $campo->tipo === 'telefone')
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
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @endforeach
    </div>
    <!-- Fim do Container de Blocos -->

    <!-- Botão de Compartilhamento WhatsApp -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="https://web.whatsapp.com/send?text={{ urlencode('Confira este evento: ' . url('/' . $evento->slug)) }}"
           target="_blank"
           class="bg-green-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition-colors">
            <i class="fab fa-whatsapp text-2xl"></i>
        </a>
    </div>

    <!-- Footer -->
    <footer class="bg-principal text-white py-4 mt-12">
        <div class="container mx-auto px-4 text-center">
            <!-- Rodapé reservado para informações futuras -->
        </div>
    </footer>

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        let editMode = false;
        let sortableInstance = null;

        function toggleEditMode() {
            editMode = !editMode;
            const container = document.getElementById('blocos-container');
            const btn = document.getElementById('toggleEditMode');

            if (editMode) {
                // Ativar modo de edição
                container.classList.add('edit-mode');
                btn.innerHTML = '<i class="fas fa-save text-xl"></i>';
                btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                btn.classList.add('bg-green-600', 'hover:bg-green-700');
                btn.title = 'Salvar ordem';

                // Mostrar toast
                mostrarToast('Modo de edição ativado! Arraste os blocos para reordenar.', 'info');

                // Inicializar SortableJS para blocos
                sortableInstance = new Sortable(container, {
                    animation: 150,
                    handle: '.bloco-secao',
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        // Salvar será feito ao clicar no botão
                    }
                });

                // Inicializar drag and drop para componentes do hero
                initHeroComponentsDragDrop();
            } else {
                // Desativar e salvar
                salvarOrdem();
                container.classList.remove('edit-mode');
                btn.innerHTML = '<i class="fas fa-edit text-xl"></i>';
                btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                btn.title = 'Ativar modo de edição';

                // Destruir SortableJS
                if (sortableInstance) {
                    sortableInstance.destroy();
                    sortableInstance = null;
                }
            }
        }

        function salvarOrdem() {
            const container = document.getElementById('blocos-container');
            const secoes = container.querySelectorAll('.bloco-secao');
            const blocos = [];
            const formularios = [];

            secoes.forEach((secao, index) => {
                if (secao.dataset.blocoId) {
                    blocos.push(secao.dataset.blocoId);
                } else if (secao.dataset.formularioId) {
                    formularios.push(secao.dataset.formularioId);
                }
            });

            // Enviar para o servidor
            fetch('{{ route("eventos.blocos.reorder", $evento) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    blocos: blocos
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarToast('Ordem salva com sucesso!', 'success');
                }
            })
            .catch(error => {
                console.error('Erro ao salvar:', error);
                mostrarToast('Erro ao salvar a ordem. Tente novamente.', 'error');
            });

            // Salvar ordem dos formulários se houver
            if (formularios.length > 0) {
                fetch('{{ route("eventos.formularios.reorder", $evento) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        formularios: formularios
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Ordem dos formulários salva');
                    }
                })
                .catch(error => {
                    console.error('Erro ao salvar formulários:', error);
                });
            }
        }

        function mostrarToast(mensagem, tipo = 'success') {
            const colors = {
                'success': 'bg-green-500',
                'error': 'bg-red-500',
                'info': 'bg-blue-500'
            };
            const icons = {
                'success': 'fa-check-circle',
                'error': 'fa-exclamation-circle',
                'info': 'fa-info-circle'
            };

            const toast = document.createElement('div');
            toast.className = `fixed top-4 left-1/2 transform -translate-x-1/2 ${colors[tipo]} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300`;
            toast.innerHTML = `<i class="fas ${icons[tipo]} mr-2"></i>${mensagem}`;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Drag and drop para componentes do hero
        let heroComponentsSortables = [];

        function initHeroComponentsDragDrop() {
            // Destruir sortables anteriores
            heroComponentsSortables.forEach(s => s.destroy());
            heroComponentsSortables = [];

            if (!editMode) return;

            // Inicializar sortable para cada container de componentes do hero
            document.querySelectorAll('[id^="hero-components-"]').forEach(container => {
                const blocoId = container.id.replace('hero-components-', '');
                const sortable = new Sortable(container, {
                    animation: 150,
                    handle: '.hero-component',
                    ghostClass: 'sortable-ghost',
                    onEnd: function(evt) {
                        // Capturar nova ordem
                        const componentes = [];
                        container.querySelectorAll('.hero-component').forEach(comp => {
                            componentes.push(comp.dataset.component);
                        });

                        // Salvar ordem
                        fetch(`/eventos/{{ $evento->id }}/blocos/${blocoId}/ordem-componentes`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                ordem: componentes
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                mostrarToast('Ordem dos componentes salva!', 'success');
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao salvar ordem:', error);
                            mostrarToast('Erro ao salvar ordem dos componentes', 'error');
                        });
                    }
                });

                heroComponentsSortables.push(sortable);
            });
        }
    </script>
</body>
</html>
