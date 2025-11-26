@extends('layouts.app')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('eventos.blocos.index', $evento) }}"
               class="inline-flex items-center justify-center w-10 h-10 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 focus:outline-none"
               title="Voltar">
                <i class="fas fa-chevron-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Bloco</h1>
                <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
            </div>
        </div>

        <!-- Formulário -->
        <form action="{{ route('eventos.blocos.update', [$evento, $bloco]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Configurações Básicas</h2>

                <!-- Tipo de Bloco -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Bloco *
                    </label>
                    <select name="tipo" required
                            style="
                                background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%23666%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e');
                                background-repeat: no-repeat;
                                background-position: right 0.75rem center;
                                background-size: 1.2em;
                                padding-right: 2.5rem;
                            "
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-100 appearance-none cursor-not-allowed"
                            disabled>
                        <option value="{{ $bloco->tipo }}" selected>
                            @if($bloco->tipo === 'hero')
                                Seção com imagem
                            @elseif($bloco->tipo === 'descricao')
                                Seção sem imagem
                            @elseif($bloco->tipo === 'agenda')
                                Agenda
                            @elseif($bloco->tipo === 'banner')
                                Banner
                            @elseif($bloco->tipo === 'mapa')
                                Mapa
                            @elseif($bloco->tipo === 'galeria')
                                Galeria
                            @else
                                {{ ucfirst($bloco->tipo) }}
                            @endif
                        </option>
                    </select>
                    <input type="hidden" name="tipo" value="{{ $bloco->tipo }}">
                    <p class="text-xs text-gray-500 mt-1">O tipo do bloco não pode ser alterado após a criação</p>
                </div>

                <!-- Status -->
                <div class="flex items-center mb-6">
                    <input type="checkbox" name="ativo" value="1" {{ $bloco->ativo ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label class="ml-2 text-sm font-medium text-gray-700">
                        Bloco ativo (visível na landing page)
                    </label>
                </div>
            </div>

            <!-- Conteúdo Específico por Tipo -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Conteúdo</h2>

                @if($bloco->tipo === 'hero')
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Subtítulo
                        </label>
                        <input type="text" name="conteudo[subtitulo]"
                               value="{{ $bloco->conteudo['subtitulo'] ?? '' }}"
                               placeholder="Ex: Um evento incrível está chegando!"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Imagem / Logo
                        </label>

                        @if($bloco->conteudo && isset($bloco->conteudo['imagem']))
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Imagem atual:</p>
                            <img src="{{ asset('storage/' . $bloco->conteudo['imagem']) }}"
                                 alt="Imagem atual"
                                 class="max-w-xs rounded-lg shadow-sm border border-gray-200">
                            <p class="text-xs text-gray-500 mt-2">Faça upload de uma nova imagem para substituir</p>
                        </div>
                        @endif

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-sm text-gray-600 mb-2">Clique para selecionar ou arraste uma imagem</p>
                            <p class="text-xs text-gray-500 mb-4">PNG, JPG, JPEG até 3MB</p>
                            <input type="file"
                                   name="conteudo[imagem]"
                                   accept="image/png,image/jpeg,image/jpg"
                                   class="hidden"
                                   id="hero-image-upload"
                                   onchange="previewHeroImage(event)">
                            <label for="hero-image-upload"
                                   class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 cursor-pointer">
                                Selecionar Imagem
                            </label>
                        </div>

                        <div id="hero-image-preview-container" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                            <img id="hero-image-preview" class="max-w-xs rounded-lg shadow-sm border border-gray-200">
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Você poderá mover e posicionar esta imagem na landing page
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Imagem de Fundo
                        </label>

                        @if($bloco->conteudo && isset($bloco->conteudo['imagem_fundo']))
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Imagem atual:</p>
                            <img src="{{ asset('storage/' . $bloco->conteudo['imagem_fundo']) }}"
                                 alt="Fundo atual"
                                 class="max-w-md rounded-lg shadow-sm border border-gray-200">
                            <p class="text-xs text-gray-500 mt-2">Faça upload de uma nova imagem para substituir</p>
                        </div>
                        @endif

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-sm text-gray-600 mb-2">Clique para selecionar ou arraste uma imagem</p>
                            <p class="text-xs text-gray-500 mb-4">PNG, JPG, JPEG até 5MB</p>
                            <input type="file"
                                   name="conteudo[imagem_fundo]"
                                   accept="image/png,image/jpeg,image/jpg"
                                   class="hidden"
                                   id="hero-bg-upload"
                                   onchange="previewHeroBackground(event)">
                            <label for="hero-bg-upload"
                                   class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 cursor-pointer">
                                Selecionar Imagem
                            </label>
                        </div>

                        <div id="hero-preview-container" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                            <img id="hero-preview-image" class="max-w-md rounded-lg shadow-sm border border-gray-200">
                        </div>
                    </div>

                @elseif($bloco->tipo === 'descricao')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Título
                        </label>
                        <input type="text" name="conteudo[titulo]"
                               value="{{ $bloco->conteudo['titulo'] ?? '' }}"
                               placeholder="Ex: Sobre o Evento"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Texto
                        </label>
                        <textarea name="conteudo[texto]" rows="6"
                                  placeholder="Descreva o evento..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $bloco->conteudo['texto'] ?? '' }}</textarea>
                    </div>

                @elseif($bloco->tipo === 'mapa')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Código Iframe do Mapa (Google Maps)
                        </label>
                        <textarea name="conteudo[iframe]" rows="4"
                                  placeholder='Cole aqui o código do iframe do Google Maps (ex: <iframe src="..." ...></iframe>)'
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm">{{ $bloco->conteudo['iframe'] ?? '' }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            Para obter o código: Abra o Google Maps → Pesquise o local → Clique em "Compartilhar" → "Incorporar um mapa"
                        </p>
                    </div>

                @elseif($bloco->tipo === 'agenda')
                    <div class="space-y-4">
                        <p class="text-sm text-gray-600 mb-4">
                            Adicione os horários e atividades da programação do evento. Use o formato JSON abaixo:
                        </p>
                        <textarea name="conteudo_json" rows="10"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm">{{ json_encode($bloco->conteudo['itens'] ?? [[
    'horario' => '09:00',
    'titulo' => 'Abertura',
    'descricao' => 'Credenciamento e boas-vindas'
]], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                        <p class="text-xs text-gray-500">
                            Formato: Array de objetos com "horario", "titulo" e "descricao" (opcional)
                        </p>
                    </div>

                @elseif($bloco->tipo === 'banner')
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Altura do Banner
                        </label>

                        <div class="flex items-center gap-4">
                            <!-- Botões de controle -->
                            <button type="button" onclick="ajustarAltura(-50)"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-bold text-xl">
                                −
                            </button>

                            <!-- Display da altura atual -->
                            <div class="flex-1 text-center">
                                <input type="number"
                                       id="altura-input"
                                       name="conteudo[altura]"
                                       value="{{ $bloco->conteudo['altura'] ?? 500 }}"
                                       min="100"
                                       max="800"
                                       step="50"
                                       class="w-32 px-4 py-2 border border-gray-300 rounded-lg text-center text-2xl font-bold focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-sm text-gray-600 mt-1">pixels</p>
                            </div>

                            <button type="button" onclick="ajustarAltura(50)"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-bold text-xl">
                                +
                            </button>
                        </div>

                        <!-- Botões de tamanhos pré-definidos -->
                        <div class="flex gap-2 mt-4">
                            <button type="button" onclick="definirAltura(100)"
                                    class="flex-1 px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm">
                                Muito Baixo (100px)
                            </button>
                            <button type="button" onclick="definirAltura(200)"
                                    class="flex-1 px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm">
                                Baixo (200px)
                            </button>
                            <button type="button" onclick="definirAltura(300)"
                                    class="flex-1 px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm">
                                Médio (300px)
                            </button>
                            <button type="button" onclick="definirAltura(500)"
                                    class="flex-1 px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm">
                                Alto (500px)
                            </button>
                        </div>

                        <p class="text-xs text-gray-500 mt-2">Use os botões + e − para ajustar, ou digite o valor manualmente (100-800px)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Imagem do Banner
                        </label>

                        @if($bloco->conteudo && isset($bloco->conteudo['imagens']) && count($bloco->conteudo['imagens']) > 0)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Imagem atual:</p>
                            <img src="{{ asset('storage/' . $bloco->conteudo['imagens'][0]) }}"
                                 alt="Banner atual"
                                 class="max-w-md rounded-lg shadow-sm border border-gray-200">
                            <p class="text-xs text-gray-500 mt-2">Faça upload de uma nova imagem para substituir</p>
                        </div>
                        @endif

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-sm text-gray-600 mb-2">Clique para selecionar ou arraste uma imagem</p>
                            <p class="text-xs text-gray-500 mb-4">PNG, JPG, JPEG até 5MB</p>
                            <input type="file"
                                   name="conteudo[imagens][]"
                                   accept="image/png,image/jpeg,image/jpg"
                                   class="hidden"
                                   id="banner-upload"
                                   onchange="previewBanner(event)">
                            <label for="banner-upload"
                                   class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 cursor-pointer">
                                Selecionar Imagem
                            </label>
                        </div>

                        <div id="preview-container" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                            <img id="preview-image" class="max-w-md rounded-lg shadow-sm border border-gray-200">
                        </div>
                    </div>

                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-2"></i>
                            Este tipo de bloco ({{ $bloco->tipo }}) requer configuração avançada.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Botões -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('eventos.blocos.index', $evento) }}"
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Funções para ajustar altura do banner
function ajustarAltura(valor) {
    const input = document.getElementById('altura-input');
    let alturaAtual = parseInt(input.value) || 500;
    let novaAltura = alturaAtual + valor;

    // Limitar entre 100 e 800
    novaAltura = Math.max(100, Math.min(800, novaAltura));

    input.value = novaAltura;
}

function definirAltura(valor) {
    const input = document.getElementById('altura-input');
    input.value = valor;
}

// Processar JSON da agenda antes de enviar
document.querySelector('form').addEventListener('submit', function(e) {
    const jsonTextarea = document.querySelector('textarea[name="conteudo_json"]');
    if (jsonTextarea) {
        try {
            const parsed = JSON.parse(jsonTextarea.value);
            // Criar input hidden com o array parseado
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'conteudo[itens]';
            input.value = JSON.stringify(parsed);
            this.appendChild(input);
        } catch (err) {
            e.preventDefault();
            alert('Erro no formato JSON da agenda. Verifique a sintaxe.');
        }
    }
});

// Preview da imagem do banner
function previewBanner(event) {
    const file = event.target.files[0];
    if (file) {
        // Verificar tamanho (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('A imagem deve ter no máximo 5MB');
            event.target.value = '';
            return;
        }

        // Verificar tipo
        const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert('Apenas imagens PNG, JPG ou JPEG são permitidas');
            event.target.value = '';
            return;
        }

        // Mostrar preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Preview da imagem/logo do hero
function previewHeroImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Verificar tamanho (3MB)
        if (file.size > 3 * 1024 * 1024) {
            alert('A imagem deve ter no máximo 3MB');
            event.target.value = '';
            return;
        }

        // Verificar tipo
        const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert('Apenas imagens PNG, JPG ou JPEG são permitidas');
            event.target.value = '';
            return;
        }

        // Mostrar preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewContainer = document.getElementById('hero-image-preview-container');
            const previewImage = document.getElementById('hero-image-preview');
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Preview da imagem de fundo do hero
function previewHeroBackground(event) {
    const file = event.target.files[0];
    if (file) {
        // Verificar tamanho (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('A imagem deve ter no máximo 5MB');
            event.target.value = '';
            return;
        }

        // Verificar tipo
        const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert('Apenas imagens PNG, JPG ou JPEG são permitidas');
            event.target.value = '';
            return;
        }

        // Mostrar preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewContainer = document.getElementById('hero-preview-container');
            const previewImage = document.getElementById('hero-preview-image');
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Drag and drop para banner
const bannerUploadArea = document.querySelector('.border-dashed');
if (bannerUploadArea) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        bannerUploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        bannerUploadArea.addEventListener(eventName, () => {
            bannerUploadArea.classList.add('border-blue-500', 'bg-blue-50');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        bannerUploadArea.addEventListener(eventName, () => {
            bannerUploadArea.classList.remove('border-blue-500', 'bg-blue-50');
        });
    });

    bannerUploadArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        const input = document.getElementById('banner-upload');
        input.files = files;
        previewBanner({ target: input });
    });
}
</script>
@endsection
