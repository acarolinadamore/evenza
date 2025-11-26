@extends('layouts.app')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('eventos.landing-page.edit', $evento) }}"
                   class="inline-flex items-center justify-center w-10 h-10 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 focus:outline-none"
                   title="Voltar">
                    <i class="fas fa-chevron-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Formulários</h1>
                    <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
                </div>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('eventos.formularios.create', $evento) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>Novo Formulário
                </a>
            </div>
        </div>

        <!-- Lista de Formulários -->
        @if($formularios->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($formularios as $formulario)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $formulario->nome }}</h3>
                            <p class="text-sm text-gray-500">/{{ $evento->slug }}/formulario/{{ $formulario->slug }}</p>
                        </div>
                        @if($formulario->ativo)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Ativo
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Inativo
                        </span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-list mr-2"></i>{{ $formulario->campos->count() }} campo(s)
                        </div>
                        <div class="text-sm text-gray-600 mt-1">
                            <i class="fas fa-inbox mr-2"></i>{{ $formulario->respostas->count() }} resposta(s)
                        </div>
                    </div>

                    <!-- Configuração Landing Page -->
                    <div class="mb-4 pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-globe mr-1"></i>Configuração Landing Page
                        </h4>

                        <!-- Checkbox Exibir na Landing Page -->
                        <div class="mb-3">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                       data-formulario-id="{{ $formulario->id }}"
                                       onchange="toggleExibirLandingPage(this)"
                                       {{ $formulario->exibir_landing_page ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Exibir na landing page</span>
                            </label>
                        </div>

                        <!-- Color Picker para Background -->
                        <div id="bg-color-container-{{ $formulario->id }}"
                             class="{{ $formulario->exibir_landing_page ? '' : 'hidden' }}">
                            <label class="block text-xs text-gray-600 mb-1">
                                <i class="fas fa-palette mr-1"></i>Cor de Fundo do Container
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="color"
                                       id="bg-color-{{ $formulario->id }}"
                                       value="{{ $formulario->background_cor ?? '#ffffff' }}"
                                       class="h-10 w-20 rounded border border-gray-300 cursor-pointer"
                                       onchange="updateBackgroundCor({{ $formulario->id }}, this.value)">
                                <input type="text"
                                       id="bg-color-text-{{ $formulario->id }}"
                                       value="{{ $formulario->background_cor ?? '#ffffff' }}"
                                       class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="#ffffff"
                                       onchange="updateBackgroundCorFromText({{ $formulario->id }}, this.value)">
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('eventos.formularios.edit', [$evento, $formulario]) }}"
                           class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-sm">
                            <i class="fas fa-edit mr-1"></i>Editar
                        </a>
                        <a href="{{ route('eventos.formularios.respostas.index', [$evento, $formulario]) }}"
                           class="flex-1 text-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-sm">
                            <i class="fas fa-eye mr-1"></i>Respostas
                        </a>
                        <form action="{{ route('eventos.formularios.destroy', [$evento, $formulario]) }}"
                              method="POST"
                              class="flex-1"
                              onsubmit="return confirm('Deseja realmente excluir este formulário?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm">
                                <i class="fas fa-trash mr-1"></i>Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Nenhum formulário criado ainda</h3>
            <p class="text-gray-600 mb-6">
                Crie formulários para coletar informações dos visitantes da landing page.
            </p>
            <a href="{{ route('eventos.formularios.create', $evento) }}"
               class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i>Criar Primeiro Formulário
            </a>
        </div>
        @endif
    </div>
</div>

<script>
function toggleExibirLandingPage(checkbox) {
    const formularioId = checkbox.dataset.formularioId;
    const exibir = checkbox.checked;
    const colorContainer = document.getElementById(`bg-color-container-${formularioId}`);

    // Toggle color picker visibility
    if (exibir) {
        colorContainer.classList.remove('hidden');
    } else {
        colorContainer.classList.add('hidden');
    }

    // Save to backend
    fetch(`/eventos/{{ $evento->id }}/formularios/${formularioId}/landing-page-config`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            exibir_landing_page: exibir
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarToast(exibir ? 'Formulário adicionado à landing page' : 'Formulário removido da landing page', 'success');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        mostrarToast('Erro ao atualizar configuração', 'error');
        // Revert checkbox on error
        checkbox.checked = !exibir;
    });
}

function updateBackgroundCor(formularioId, cor) {
    // Update text input
    document.getElementById(`bg-color-text-${formularioId}`).value = cor;

    // Save to backend
    saveBackgroundCor(formularioId, cor);
}

function updateBackgroundCorFromText(formularioId, cor) {
    // Validate hex color
    const hexPattern = /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/;
    if (!hexPattern.test(cor)) {
        mostrarToast('Cor inválida. Use formato hexadecimal (#ffffff)', 'error');
        return;
    }

    // Update color picker
    document.getElementById(`bg-color-${formularioId}`).value = cor;

    // Save to backend
    saveBackgroundCor(formularioId, cor);
}

function saveBackgroundCor(formularioId, cor) {
    fetch(`/eventos/{{ $evento->id }}/formularios/${formularioId}/landing-page-config`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            background_cor: cor
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarToast('Cor de fundo atualizada', 'success');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        mostrarToast('Erro ao atualizar cor de fundo', 'error');
    });
}

function mostrarToast(mensagem, tipo) {
    // Simple toast notification
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 ${tipo === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    toast.textContent = mensagem;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>

@endsection
