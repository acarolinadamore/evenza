@extends('layouts.app')

@section('titulo', 'Novo Evento')

@section('conteudo')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex items-center gap-4 mb-8">
        <a href="/eventos"
           class="inline-flex items-center justify-center w-10 h-10 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 focus:outline-none"
           title="Voltar">
            <i class="fas fa-chevron-left text-xl"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Novo Evento</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <x-eventos.form action="/eventos/salvar" submit="Cadastrar"/>
    </div>
</div>
@endsection