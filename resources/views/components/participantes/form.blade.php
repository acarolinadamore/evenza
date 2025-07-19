<form action="{{ $action }}" method="post" class="space-y-6">
    @csrf
    @isset($participante->id)
        @method('PUT')
        <input type="hidden" name="id" value="{{ $participante->id }}">
    @endisset

    <div>
        <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
        <input type="text" 
               @isset($participante->nome) value="{{ $participante->nome }}" @endisset 
               id="nome" name="nome" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
               placeholder="Nome do participante" required>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email" 
               @isset($participante->email) value="{{ $participante->email }}" @endisset 
               id="email" name="email" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
               placeholder="email@exemplo.com (opcional)">
    </div>

    <div>
        <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
        <input type="text" 
               @isset($participante->telefone) value="{{ $participante->telefone }}" @endisset 
               id="telefone" name="telefone" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
               placeholder="(67) 99999-9999 (opcional)">
    </div>

    <div>
        <label for="evento_id" class="block text-sm font-medium text-gray-700 mb-2">Evento</label>
        <select id="evento_id" name="evento_id" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
            <option value="">Selecione um evento (opcional)</option>
            @foreach($eventos as $evento)
                <option value="{{ $evento->id }}" 
                        @isset($participante->evento_id) @if($participante->evento_id == $evento->id) selected @endif @endisset>
                    {{ $evento->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            {{ $submit }}
        </button>
        <a href="/participantes" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
            Cancelar
        </a>
    </div>
</form>