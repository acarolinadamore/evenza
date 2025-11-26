@extends('layouts.app')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="/eventos/{{ $evento->id }}"
                   class="inline-flex items-center justify-center w-10 h-10 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 focus:outline-none"
                   title="Voltar">
                    <i class="fas fa-chevron-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Landing Page</h1>
                    <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
                </div>
            </div>
            @if($evento->landing_page_ativa)
            <div class="flex justify-end">
                <a href="{{ route('landing-page.show', $evento->slug) }}" target="_blank"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-external-link-alt mr-2"></i>Ver Landing Page
                </a>
            </div>
            @endif
        </div>

        <!-- Links para Gestão de Blocos e Formulários -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
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

        <!-- Formulário de Configuração -->
        <form action="{{ route('eventos.landing-page.update', $evento) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Configurações da Landing Page -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Configurações</h2>

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

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        URL Personalizada (Slug)
                    </label>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-600">{{ url('/') }}/</span>
                        <input type="text" name="slug" value="{{ $evento->slug }}"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="meu-evento"
                               pattern="[a-z0-9-]+"
                               title="Use apenas letras minúsculas, números e hífens">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Use apenas letras minúsculas, números e hífens. Ex: workshop-laravel-2024
                    </p>
                </div>

                @if($evento->slug)
                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-gray-700">
                        <i class="fas fa-link mr-2"></i><strong>URL Atual:</strong>
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
                            Cor dos Botões
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
                        <p class="text-xs text-gray-500 mt-1">Cor dos botões e elementos interativos</p>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end gap-3 mb-6">
                <a href="/eventos/{{ $evento->id }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Salvar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
