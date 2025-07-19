@extends('layouts.app')

@section('titulo', 'Lista de Participantes')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
       <h1 class="text-5xl font-bold text-gray-800 mb-2 font-titulo">Lista de Participantes</h1>
        <a href="/participantes/novo" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
            <i class="fas fa-user-plus mr-2"></i>Novo Participante
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telefone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Evento</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($participantes as $participante)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $participante->nome }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $participante->email ?: 'Não informado' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $participante->telefone ?: 'Não informado' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $participante->evento->nome ?? 'Sem evento' }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="/participantes/editar/{{ $participante->id }}" 
                           class="bg-yellow-500 text-white px-4 py-2 rounded text-sm hover:bg-yellow-600 mr-2">
                            Editar
                        </a>
                        <form action="/participantes/excluir" method="post" class="inline">
                            @csrf 
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $participante->id }}">
                            <button type="submit" 
                                    class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600"
                                    onclick="return confirm('Deseja excluir este participante?')">
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