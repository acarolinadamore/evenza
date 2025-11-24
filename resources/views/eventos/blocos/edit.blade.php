@extends('layouts.app')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Bloco</h1>
                <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
            </div>
            <a href="{{ route('eventos.blocos.index', $evento) }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-100"
                            disabled>
                        <option value="{{ $bloco->tipo }}" selected>
                            {{ ucfirst($bloco->tipo) }}
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
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Subtítulo
                        </label>
                        <input type="text" name="conteudo[subtitulo]"
                               value="{{ $bloco->conteudo['subtitulo'] ?? '' }}"
                               placeholder="Ex: Um evento incrível está chegando!"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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

                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-2"></i>
                            Este tipo de bloco ({{ $bloco->tipo }}) requer configuração avançada ou upload de arquivos.
                            Por enquanto, o bloco está criado e pode ser ativado/desativado.
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
</script>
@endsection
