@extends('layouts.app')

@section('titulo', 'Detalhes do Participante')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-5xl font-bold text-gray-800 font-titulo">{{ $participante->nome }}</h1>
            <div class="flex gap-2">
                <a href="/participantes/editar/{{ $participante->id }}"
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-yellow-500 rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600 focus:shadow-outline focus:outline-none">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="/participantes"
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-500 hover:bg-neutral-600 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-600 focus:shadow-outline focus:outline-none">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
            </div>
        </div>

        <!-- Cards de Resumo -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="text-sm text-gray-600 mb-1">Total de Eventos</div>
                <div class="text-2xl font-bold text-gray-800">{{ $totalEventos }}</div>
                <div class="text-xs text-gray-500 mt-1">
                    @if($totalEventos > 0)
                        Participou de {{ $totalEventos }} evento{{ $totalEventos > 1 ? 's' : '' }}
                    @else
                        Ainda não participou de eventos
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="text-sm text-gray-600 mb-1">Evento Atual</div>
                <div class="text-lg font-bold text-gray-800">
                    @if($participante->evento)
                        {{ $participante->evento->nome }}
                    @else
                        <span class="text-gray-400">Não vinculado</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informações de Contato -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Informações de Contato</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <span class="text-sm text-gray-600"><i class="fas fa-user mr-2"></i>Nome:</span>
                    <p class="text-gray-800 font-medium">{{ $participante->nome }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-600"><i class="fas fa-envelope mr-2"></i>Email:</span>
                    <p class="text-gray-800">{{ $participante->email ?: 'Não informado' }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-600"><i class="fas fa-phone mr-2"></i>Contato:</span>
                    <p class="text-gray-800">
                        {{ $participante->telefone ?: 'Não informado' }}
                        @if($participante->telefone && $participante->is_whatsapp)
                            <i class="fab fa-whatsapp text-green-500 ml-2"></i>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Evento Atual -->
        @if($participante->evento)
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Evento Atual</h2>
            <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            <i class="fas fa-calendar-check text-green-500 mr-2"></i>{{ $participante->evento->nome }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Data:</span>
                                <span class="font-medium">
                                    {{ $participante->evento->data_evento ? date('d/m/Y', strtotime($participante->evento->data_evento)) : 'Não definida' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600">Local:</span>
                                <span class="font-medium">{{ $participante->evento->local ?: 'Não informado' }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="/eventos/{{ $participante->evento->id }}"
                       class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:shadow-outline focus:outline-none ml-4">
                        Ver Evento
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Histórico de Eventos -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-history mr-2"></i>Histórico de Participações
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Eventos anteriores vinculados ao mesmo email ou telefone
            </p>
        </div>

        @if($historico->count() > 0)
        <div class="p-6">
            <div class="space-y-4">
                @foreach($historico as $registro)
                @if($registro->evento)
                <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">
                                <i class="fas fa-calendar text-gray-400 mr-2"></i>{{ $registro->evento->nome }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Data:</span>
                                    <span class="font-medium">
                                        {{ $registro->evento->data_evento ? date('d/m/Y', strtotime($registro->evento->data_evento)) : 'Não definida' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Local:</span>
                                    <span class="font-medium">{{ $registro->evento->local ?: 'Não informado' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Inscrição:</span>
                                    <span class="font-medium">{{ date('d/m/Y', strtotime($registro->created_at)) }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="/eventos/{{ $registro->evento->id }}"
                           class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-neutral-600 rounded-md hover:bg-neutral-700 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-700 focus:shadow-outline focus:outline-none ml-4">
                            Ver Evento
                        </a>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @else
        <div class="p-12 text-center text-gray-500">
            <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
            <p class="text-lg">Nenhum histórico encontrado.</p>
            <p class="text-sm text-gray-400 mt-2">Este participante não tem registros anteriores vinculados ao mesmo email ou telefone.</p>
        </div>
        @endif
    </div>
</div>
@endsection
