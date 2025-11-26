@extends('layouts.app')

@section('titulo', 'Adicionar Organizador')

@section('conteudo')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex items-center gap-4 mb-2">
        <a href="/eventos/{{ $evento->id }}"
           class="inline-flex items-center justify-center w-10 h-10 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 focus:outline-none"
           title="Voltar">
            <i class="fas fa-chevron-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Adicionar Organizador</h1>
            <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-8" x-data="{ tipo: 'novo' }">
        <!-- Tabs -->
        <div class="flex border-b border-gray-200 mb-6">
            <button @click="tipo = 'novo'"
                    :class="tipo === 'novo' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-2 px-4 border-b-2 font-medium text-sm transition-colors">
                <i class="fas fa-user-plus mr-2"></i>Novo Organizador
            </button>
            <button @click="tipo = 'existente'"
                    :class="tipo === 'existente' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="py-2 px-4 border-b-2 font-medium text-sm transition-colors">
                <i class="fas fa-users mr-2"></i>Selecionar Usuário já cadastrado
            </button>
        </div>

        <!-- Novo Organizador Form -->
        <form x-show="tipo === 'novo'" action="{{ route('eventos.organizadores.store', $evento) }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome <span class="text-red-600">*</span></label>
                <input type="text" name="nome" id="nome" required
                       class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">
                @error('nome')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="cargo" class="block text-sm font-medium text-gray-700 mb-2">
                    Função <span class="text-gray-400 font-normal">(opcional)</span>
                </label>
                <input type="text" name="cargo" id="cargo"
                       class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">
                @error('cargo')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-gray-400 font-normal">(opcional)</span>
                </label>
                <input type="email" name="email" id="email"
                       class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">
                    Contato <span class="text-gray-400 font-normal">(opcional)</span>
                </label>
                <input type="text" name="telefone" id="telefone"
                       class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">
                @error('telefone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <div class="flex items-center mt-2">
                    <input type="checkbox" name="is_whatsapp" id="is_whatsapp" value="1" checked
                           class="w-4 h-4 text-green-600 bg-white border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                    <label for="is_whatsapp" class="ml-2 text-sm font-medium text-gray-700">
                        <i class="fab fa-whatsapp text-green-500 mr-1"></i>É WhatsApp?
                    </label>
                </div>
            </div>

            <div class="flex gap-4 justify-end">
                <a href="/eventos/{{ $evento->id }}"
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-500 hover:bg-neutral-600 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-600 focus:shadow-outline focus:outline-none">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-purple-600 hover:bg-purple-700 focus:ring-2 focus:ring-offset-2 focus:ring-purple-700 focus:shadow-outline focus:outline-none">
                    Cadastrar
                </button>
            </div>
        </form>

        <!-- Selecionar Usuário Existente Form -->
        <form x-show="tipo === 'existente'" action="{{ route('eventos.organizadores.store', $evento) }}" method="POST" class="space-y-6" style="display: none;">
            @csrf
            <input type="hidden" name="from_user" value="1">

            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Selecionar Usuário <span class="text-red-600">*</span></label>
                <select name="user_id" id="user_id" required
                        class="w-full h-10 px-4 pr-12 py-2 text-sm bg-white border rounded-lg border-gray-300 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-600 appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e')] bg-[length:1.2em] bg-[right_0.7rem_center] bg-no-repeat hover:border-gray-400 transition-colors">
                    <option value="">Selecione um usuário</option>
                    @php
                        $users = \App\Models\User::orderBy('name')->get();
                    @endphp
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">O nome e email do usuário serão usados como organizador</p>
            </div>

            <div>
                <label for="cargo_user" class="block text-sm font-medium text-gray-700 mb-2">
                    Função <span class="text-gray-400 font-normal">(opcional)</span>
                </label>
                <input type="text" name="cargo" id="cargo_user"
                       class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">
            </div>

            <div>
                <label for="telefone_user" class="block text-sm font-medium text-gray-700 mb-2">
                    Contato <span class="text-gray-400 font-normal">(opcional)</span>
                </label>
                <input type="text" name="telefone" id="telefone_user"
                       class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">
                <div class="flex items-center mt-2">
                    <input type="checkbox" name="is_whatsapp" id="is_whatsapp_user" value="1" checked
                           class="w-4 h-4 text-green-600 bg-white border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                    <label for="is_whatsapp_user" class="ml-2 text-sm font-medium text-gray-700">
                        <i class="fab fa-whatsapp text-green-500 mr-1"></i>É WhatsApp?
                    </label>
                </div>
            </div>

            <div class="flex gap-4 justify-end">
                <a href="/eventos/{{ $evento->id }}"
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-500 hover:bg-neutral-600 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-600 focus:shadow-outline focus:outline-none">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-purple-600 hover:bg-purple-700 focus:ring-2 focus:ring-offset-2 focus:ring-purple-700 focus:shadow-outline focus:outline-none">
                    Adicionar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
