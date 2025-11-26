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
                <h1 class="text-3xl font-bold text-gray-800">Novo Bloco de Conteúdo</h1>
                <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
            </div>
        </div>

        <!-- Formulário -->
        <form action="{{ route('eventos.blocos.store', $evento) }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none hover:border-gray-400 transition-colors cursor-pointer">
                        <option value="" class="bg-white py-2 px-3">Selecione o tipo...</option>
                        <option value="hero" class="bg-white py-2 px-3">Seção com imagem - Título, Imagem, texto</option>
                        <option value="descricao" class="bg-white py-2 px-3">Seção sem imagem - Título e Texto</option>
                        <option value="banner" class="bg-white py-2 px-3">Banner - Imagem de destaque</option>
                        <option value="mapa" class="bg-white py-2 px-3">Mapa - Localização</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="ativo" value="1" checked
                           class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label class="ml-2 text-sm font-medium text-gray-700">
                        Bloco ativo (visível na landing page)
                    </label>
                </div>
            </div>

            <!-- Info sobre conteúdo -->
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                <p class="text-sm text-yellow-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Nota:</strong> Após criar o bloco, você poderá editá-lo para adicionar o conteúdo específico (textos, imagens, etc).
                </p>
            </div>

            <!-- Botões -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('eventos.blocos.index', $evento) }}"
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-save mr-2"></i>Criar Bloco
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
