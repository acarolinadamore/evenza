@extends('layouts.app')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Configurar Landing Page</h1>
                <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
            </div>
            <div class="flex gap-3">
                @if($evento->landing_page_ativa)
                <a href="{{ route('landing-page.show', $evento->slug) }}" target="_blank"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-external-link-alt mr-2"></i>Ver Landing Page
                </a>
                @endif
                <a href="/eventos/{{ $evento->id }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
            </div>
        </div>

        <!-- Formulário de Configuração -->
        <form action="{{ route('eventos.landing-page.update', $evento) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Status da Landing Page -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Status</h2>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">Landing Page Ativa</p>
                        <p class="text-sm text-gray-600">Permite que o público acesse a página via /{!! $evento->slug !!}</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="landing_page_ativa" value="1"
                               @if($evento->landing_page_ativa) checked @endif
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                @if($evento->slug)
                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-gray-700">
                        <i class="fas fa-link mr-2"></i><strong>URL da Landing Page:</strong>
                        <a href="{{ url('/' . $evento->slug) }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ url('/' . $evento->slug) }}
                        </a>
                    </p>
                </div>
                @endif
            </div>

            <!-- Cores e Tema -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Tema e Cores</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Cor Principal
                        </label>
                        <div class="flex gap-2">
                            <input type="color"
                                   name="cor_principal"
                                   value="{{ $evento->tema->cor_principal ?? '#1a1a1a' }}"
                                   class="h-10 w-20 rounded border border-gray-300">
                            <input type="text"
                                   value="{{ $evento->tema->cor_principal ?? '#1a1a1a' }}"
                                   readonly
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Cor de fundo do hero e footer</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Cor de Destaque
                        </label>
                        <div class="flex gap-2">
                            <input type="color"
                                   name="cor_destaque"
                                   value="{{ $evento->tema->cor_destaque ?? '#ad8741' }}"
                                   class="h-10 w-20 rounded border border-gray-300">
                            <input type="text"
                                   value="{{ $evento->tema->cor_destaque ?? '#ad8741' }}"
                                   readonly
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Cor dos botões e destaques</p>
                    </div>
                </div>
            </div>

            <!-- Imagens -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Imagens</h2>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Logo
                        </label>
                        @if($evento->tema && $evento->tema->logo)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $evento->tema->logo) }}"
                                 alt="Logo atual"
                                 class="h-16 border border-gray-200 rounded p-2">
                        </div>
                        @endif
                        <input type="file"
                               name="logo"
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">Aparece no topo da landing page (máx. 2MB)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Imagem de Fundo (Hero)
                        </label>
                        @if($evento->tema && $evento->tema->imagem_fundo)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $evento->tema->imagem_fundo) }}"
                                 alt="Fundo atual"
                                 class="h-32 w-64 object-cover border border-gray-200 rounded">
                        </div>
                        @endif
                        <input type="file"
                               name="imagem_fundo"
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">Imagem de fundo da seção hero (máx. 5MB)</p>
                    </div>
                </div>
            </div>

            <!-- Template de Mensagem WhatsApp -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Mensagem de Compartilhamento</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Template da Mensagem WhatsApp
                    </label>
                    <textarea name="template_mensagem_compartilhar"
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Olá {nome}! Você está confirmado no evento {evento_nome}...">{{ $evento->tema->template_mensagem_compartilhar ?? '' }}</textarea>
                    <p class="text-xs text-gray-500 mt-2">
                        Variáveis disponíveis: {nome}, {email}, {contato}, {evento_nome}, {evento_data}, {evento_local}
                    </p>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end gap-3">
                <a href="/eventos/{{ $evento->id }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Salvar Configurações
                </button>
            </div>
        </form>

        <!-- Links para Gestão de Blocos e Formulários -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <a href="{{ route('eventos.blocos.index', $evento) }}"
               class="block bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg p-6 hover:from-purple-600 hover:to-purple-700 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2">Blocos de Conteúdo</h3>
                        <p class="text-sm opacity-90">Gerencie seções de hero, descrição, agenda, banners, etc.</p>
                    </div>
                    <i class="fas fa-th-large text-3xl opacity-75"></i>
                </div>
            </a>

            <a href="{{ route('eventos.formularios.index', $evento) }}"
               class="block bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg p-6 hover:from-green-600 hover:to-green-700 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2">Formulários</h3>
                        <p class="text-sm opacity-90">Crie formulários personalizados para captar informações</p>
                    </div>
                    <i class="fas fa-clipboard-list text-3xl opacity-75"></i>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
