@extends('layouts.app')

@section('titulo', 'Novo Usuário')

@section('conteudo')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center justify-center w-10 h-10 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 focus:outline-none"
           title="Voltar">
            <i class="fas fa-chevron-left text-xl"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Novo Usuário</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                       required>
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                       required>
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                <input type="password"
                       id="password"
                       name="password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                       required>
                @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Mínimo de 8 caracteres</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Senha</label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Função</label>
                <select id="role"
                        name="role"
                        class="w-full h-10 px-4 pr-12 py-2 text-sm bg-white border rounded-lg border-gray-300 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-600 appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e')] bg-[length:1.2em] bg-[right_0.7rem_center] bg-no-repeat hover:border-gray-400 transition-colors"
                        required
                        x-data="{ role: '{{ old('role', 'organizador') }}' }"
                        x-model="role">
                    <option value="organizador">Organizador</option>
                    <option value="administrador">Administrador</option>
                </select>
                @error('role')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{ role: '{{ old('role', 'organizador') }}' }"
                 x-init="document.getElementById('role').addEventListener('change', (e) => role = e.target.value)">
                <div x-show="role === 'organizador'" class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Eventos</label>
                    <p class="text-xs text-gray-500 mb-3">Deixe vazio para permitir acesso a todos os eventos</p>

                    @if($eventos->count() > 0)
                    <div class="max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-3 space-y-2">
                        @foreach($eventos as $evento)
                        <label class="flex items-center hover:bg-gray-50 p-2 rounded cursor-pointer">
                            <input type="checkbox"
                                   name="eventos[]"
                                   value="{{ $evento->id }}"
                                   {{ in_array($evento->id, old('eventos', [])) ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">{{ $evento->nome }}</span>
                        </label>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-gray-500">Nenhum evento cadastrado</p>
                    @endif
                </div>
            </div>

            <div class="flex gap-4 justify-end pt-4">
                <a href="{{ route('admin.users.index') }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-gradient-to-r from-purple-600 to-red-600 hover:from-purple-700 hover:to-red-700 text-white px-6 py-2 rounded-lg transition-all">
                    Criar Usuário
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
