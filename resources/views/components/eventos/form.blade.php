<form action="{{ $action }}" method="post" class="space-y-6">
    @csrf
    @isset($evento->id)
        @method('PUT')
        <input type="hidden" name="id" value="{{ $evento->id }}">
    @endisset

    <div>
        <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome do Evento *</label>
        <input type="text" 
               @isset($evento->nome) value="{{ $evento->nome }}" @endisset 
               id="nome" name="nome" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
               placeholder="Digite o nome do evento" required>
    </div>

    <div>
        <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
        <textarea id="descricao" name="descricao" rows="3"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                  placeholder="Descreva o evento (opcional)">@isset($evento->descricao){{ $evento->descricao }}@endisset</textarea>
    </div>

    <div>
        <label for="data_evento" class="block text-sm font-medium text-gray-700 mb-2">Data do Evento</label>
        <input type="date" 
               @isset($evento->data_evento) value="{{ $evento->data_evento }}" @endisset 
               id="data_evento" name="data_evento" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
        <label for="local" class="block text-sm font-medium text-gray-700 mb-2">Local</label>
        <input type="text" 
               @isset($evento->local) value="{{ $evento->local }}" @endisset 
               id="local" name="local" 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
               placeholder="Local do evento (opcional)">
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            {{ $submit }}
        </button>
        <a href="/eventos" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
            Cancelar
        </a>
    </div>
</form>