@extends('layouts.app')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Novo Bloco de Conteúdo</h1>
                <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
            </div>
            <a href="{{ route('eventos.blocos.index', $evento) }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Selecione o tipo...</option>
                        <option value="hero">Hero - Seção principal de destaque</option>
                        <option value="descricao">Descrição - Texto sobre o evento</option>
                        <option value="agenda">Agenda - Programação do evento</option>
                        <option value="banner">Banner - Imagem de destaque</option>
                        <option value="mapa">Mapa - Localização</option>
                        <option value="galeria">Galeria - Grade de fotos</option>
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
