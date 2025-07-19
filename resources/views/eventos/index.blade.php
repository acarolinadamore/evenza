@extends('layouts.app')

@section('titulo', 'Lista de Eventos')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-5xl font-bold text-gray-800 mb-2 font-titulo">Lista de Eventos</h1>
        <a href="/eventos/novo" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Novo Evento
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Local</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Participantes</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($eventos as $evento)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $evento->nome }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ date('d/m/Y', strtotime($evento->data_evento)) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $evento->local }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $evento->participantes->count() }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="/eventos/editar/{{ $evento->id }}" 
                           class="bg-yellow-500 text-white px-4 py-2 rounded text-sm hover:bg-yellow-600 mr-2">
                            Editar
                        </a>
                        <form action="/eventos/excluir" method="post" class="inline">
                            @csrf 
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $evento->id }}">
                            <button type="submit" 
                                    class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600"
                                    onclick="return confirm('Deseja excluir este evento?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection