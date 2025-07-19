@extends('layouts.app')

@section('titulo', 'Novo Evento')

@section('conteudo')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Novo Evento</h1>
        <a href="/eventos" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            <i class="fas fa-arrow-left mr-2"></i>Voltar
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <x-eventos.form action="/eventos/salvar" submit="Cadastrar Evento"/>
    </div>
</div>
@endsection