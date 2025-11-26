@extends('layouts.app')

@section('titulo', 'Detalhes do Participante')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="/participantes"
               class="inline-flex items-center justify-center w-10 h-10 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 focus:outline-none"
               title="Voltar">
                <i class="fas fa-chevron-left text-xl"></i>
            </a>
            <h1 class="text-5xl font-bold text-gray-800 font-titulo">{{ $participante->nome }}</h1>
        </div>

        <div class="flex justify-end gap-2 mb-4">
            <a href="/participantes/editar/{{ $participante->id }}"
               class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-yellow-500 rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600 focus:shadow-outline focus:outline-none">
                <i class="fas fa-edit mr-2"></i>Editar
            </a>
        </div>

        <!-- Cards de Informações do Participante -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Card Email -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-envelope text-blue-600 text-lg"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Email</h3>
                </div>
                @if($participante->email)
                <p class="text-sm text-gray-700 leading-snug break-all" title="{{ $participante->email }}">
                    {{ Str::limit($participante->email, 40) }}
                </p>
                @else
                <p class="text-sm text-gray-500">Não informado</p>
                @endif
            </div>

            <!-- Card Telefone -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-phone text-green-600 text-lg"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Telefone</h3>
                </div>
                @if($participante->telefone)
                    @php
                        $tel = preg_replace('/\D/', '', $participante->telefone);
                        if (strlen($tel) == 11) {
                            $telFormatado = '(' . substr($tel, 0, 2) . ') ' . substr($tel, 2, 5) . '-' . substr($tel, 7);
                        } elseif (strlen($tel) == 10) {
                            $telFormatado = '(' . substr($tel, 0, 2) . ') ' . substr($tel, 2, 4) . '-' . substr($tel, 6);
                        } else {
                            $telFormatado = $participante->telefone;
                        }
                    @endphp
                <p class="text-sm text-gray-700 leading-snug mb-2">
                    {{ $telFormatado }}
                    @if($participante->is_whatsapp)
                        <i class="fab fa-whatsapp text-green-500 ml-1"></i>
                    @endif
                </p>
                @if($participante->is_whatsapp)
                <a href="https://wa.me/55{{ preg_replace('/\D/', '', $participante->telefone) }}"
                   target="_blank"
                   class="inline-flex items-center text-xs text-green-600 hover:text-green-800 font-medium">
                    <i class="fab fa-whatsapp mr-1"></i>Enviar WhatsApp
                </a>
                @endif
                @else
                <p class="text-sm text-gray-500">Não informado</p>
                @endif
            </div>

            <!-- Card Data de Nascimento -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-calendar text-purple-600 text-lg"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Data de Nascimento</h3>
                </div>
                @if($participante->data_nascimento)
                <div class="text-lg font-bold text-gray-900 mb-1">
                    {{ $participante->data_nascimento->format('d/m/Y') }}
                </div>
                @if($participante->idade)
                <p class="text-xs text-gray-600">
                    {{ $participante->idade }} anos
                </p>
                @endif
                @else
                <p class="text-sm text-gray-500">Não informado</p>
                @endif
            </div>

            <!-- Card Sexo -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-venus-mars text-pink-600 text-lg"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Sexo</h3>
                </div>
                <p class="text-sm text-gray-700">
                    @if($participante->sexo === 'feminino')
                        Feminino
                    @elseif($participante->sexo === 'masculino')
                        Masculino
                    @else
                        Não informado
                    @endif
                </p>
            </div>
        </div>

        <!-- Card de Observações (se houver) -->
        @if($participante->observacoes)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-sticky-note text-yellow-600 text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Observações</h3>
            </div>
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $participante->observacoes }}</p>
        </div>
        @endif

        <!-- Eventos Inscritos -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-calendar-check text-indigo-600 text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Eventos Inscritos</h3>
            </div>

            @if($historico->count() > 0)
                <div class="mb-3">
                    <span class="text-2xl font-bold text-gray-900">{{ $historico->count() }}</span>
                    <span class="text-sm text-gray-600 ml-2">evento{{ $historico->count() > 1 ? 's' : '' }}</span>
                </div>
                <div class="space-y-3">
                    @foreach($historico as $registro)
                    @if($registro->evento)
                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="text-base font-bold text-gray-800 mb-2">
                                    {{ $registro->evento->nome }}
                                </h4>
                                <div class="text-sm text-gray-600">
                                    <span class="inline-block mr-4">
                                        <i class="fas fa-calendar text-gray-400 mr-1"></i>
                                        {{ $registro->evento->data_evento ? date('d/m/Y', strtotime($registro->evento->data_evento)) : 'Não definida' }}
                                    </span>
                                </div>
                            </div>
                            <a href="/eventos/{{ $registro->evento->id }}"
                               class="inline-flex items-center justify-center px-3 py-2 text-xs font-medium tracking-wide text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:shadow-outline focus:outline-none ml-4">
                                Ver detalhes
                            </a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                    <p class="text-sm">Nenhum evento inscrito</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
