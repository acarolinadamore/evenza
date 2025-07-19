@extends('layouts.app')

@section('titulo', 'Painel - Evenza')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-5xl font-bold text-gray-800 mb-2 font-titulo">Painel</h1>
        <p class="text-gray-600">Gerencie seus eventos e participantes</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg border border-gray-200 p-8 hover:shadow-md transition-shadow">
            <div class="text-center mb-6">
                <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-lg mb-1 mx-auto">
                    <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-blue-600 mb-2">{{ $totalEventos }}</p>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Eventos</h2>
                <p class="text-gray-600 text-sm">Visualize e gerencie todos os seus eventos</p>
            </div>
            
            <div class="flex flex-col space-y-3">
                <a href="/eventos" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-list mr-2"></i>
                    Ver Eventos
                </a>
                <a href="/eventos/novo" class="flex items-center justify-center px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Novo Evento
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-8 hover:shadow-md transition-shadow">
            <div class="text-center mb-6">
                <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-lg mb-1 mx-auto">
                    <i class="fas fa-users text-green-600 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-green-600 mb-2">{{ $totalParticipantes }}</p>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Participantes</h2>
                <p class="text-gray-600 text-sm">Gerencie os participantes dos eventos</p>
            </div>
            
            <div class="flex flex-col space-y-3">
                <a href="/participantes" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-list mr-2"></i>
                    Ver Participantes
                </a>
                <a href="/participantes/novo" class="flex items-center justify-center px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                    <i class="fas fa-user-plus mr-2"></i>
                    Novo Participante
                </a>
            </div>
        </div>
    </div>
</div>
@endsection