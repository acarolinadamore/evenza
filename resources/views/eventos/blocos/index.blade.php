@extends('layouts.app')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Blocos de Conteúdo</h1>
                <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('eventos.blocos.create', $evento) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>Novo Bloco
                </a>
                <a href="{{ route('eventos.landing-page.edit', $evento) }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
            </div>
        </div>

        <!-- Info -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                Os blocos aparecem na landing page pública na ordem definida. Você pode criar diferentes tipos de blocos para montar a página do seu evento.
            </p>
        </div>

        <!-- Lista de Blocos -->
        @if($blocos->count() > 0)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ordem
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Conteúdo
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($blocos as $bloco)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-900">{{ $bloco->ordem + 1 }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $tipos = [
                                    'hero' => ['label' => 'Hero', 'icon' => 'fa-star', 'color' => 'purple'],
                                    'descricao' => ['label' => 'Descrição', 'icon' => 'fa-align-left', 'color' => 'blue'],
                                    'agenda' => ['label' => 'Agenda', 'icon' => 'fa-calendar', 'color' => 'green'],
                                    'banner' => ['label' => 'Banner', 'icon' => 'fa-image', 'color' => 'yellow'],
                                    'mapa' => ['label' => 'Mapa', 'icon' => 'fa-map-marker-alt', 'color' => 'red'],
                                    'galeria' => ['label' => 'Galeria', 'icon' => 'fa-images', 'color' => 'pink'],
                                ];
                                $tipo = $tipos[$bloco->tipo] ?? ['label' => $bloco->tipo, 'icon' => 'fa-question', 'color' => 'gray'];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $tipo['color'] }}-100 text-{{ $tipo['color'] }}-800">
                                <i class="fas {{ $tipo['icon'] }} mr-1"></i>
                                {{ $tipo['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($bloco->ativo)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Ativo
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-times-circle mr-1"></i>Inativo
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600">
                                @if($bloco->conteudo)
                                    @if(is_array($bloco->conteudo))
                                        {{ count($bloco->conteudo) }} item(ns)
                                    @else
                                        Configurado
                                    @endif
                                @else
                                    <span class="text-gray-400">Sem conteúdo</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('eventos.blocos.edit', [$evento, $bloco]) }}"
                               class="text-yellow-600 hover:text-yellow-900 mr-3">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('eventos.blocos.destroy', [$evento, $bloco]) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Deseja realmente excluir este bloco?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <i class="fas fa-th-large text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Nenhum bloco criado ainda</h3>
            <p class="text-gray-600 mb-6">
                Comece adicionando blocos de conteúdo para construir sua landing page.
            </p>
            <a href="{{ route('eventos.blocos.create', $evento) }}"
               class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i>Criar Primeiro Bloco
            </a>
        </div>
        @endif

        <!-- Tipos de Blocos Disponíveis -->
        <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tipos de Blocos Disponíveis</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border border-purple-200 rounded-lg p-4 bg-purple-50">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-star text-purple-600 text-xl mr-3"></i>
                        <h4 class="font-bold text-purple-900">Hero</h4>
                    </div>
                    <p class="text-sm text-purple-700">Seção principal com título e destaque</p>
                </div>

                <div class="border border-blue-200 rounded-lg p-4 bg-blue-50">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-align-left text-blue-600 text-xl mr-3"></i>
                        <h4 class="font-bold text-blue-900">Descrição</h4>
                    </div>
                    <p class="text-sm text-blue-700">Texto descritivo sobre o evento</p>
                </div>

                <div class="border border-green-200 rounded-lg p-4 bg-green-50">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-calendar text-green-600 text-xl mr-3"></i>
                        <h4 class="font-bold text-green-900">Agenda</h4>
                    </div>
                    <p class="text-sm text-green-700">Programação com horários</p>
                </div>

                <div class="border border-yellow-200 rounded-lg p-4 bg-yellow-50">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-image text-yellow-600 text-xl mr-3"></i>
                        <h4 class="font-bold text-yellow-900">Banner</h4>
                    </div>
                    <p class="text-sm text-yellow-700">Imagens de destaque</p>
                </div>

                <div class="border border-red-200 rounded-lg p-4 bg-red-50">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-map-marker-alt text-red-600 text-xl mr-3"></i>
                        <h4 class="font-bold text-red-900">Mapa</h4>
                    </div>
                    <p class="text-sm text-red-700">Localização do evento</p>
                </div>

                <div class="border border-pink-200 rounded-lg p-4 bg-pink-50">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-images text-pink-600 text-xl mr-3"></i>
                        <h4 class="font-bold text-pink-900">Galeria</h4>
                    </div>
                    <p class="text-sm text-pink-700">Grade de fotos</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
