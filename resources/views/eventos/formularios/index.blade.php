@extends('layouts.app')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Formulários</h1>
                <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('eventos.formularios.create', $evento) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>Novo Formulário
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
                Crie formulários personalizados para captar informações dos visitantes. Cada formulário pode ter múltiplos campos de diferentes tipos.
            </p>
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
@endsection
