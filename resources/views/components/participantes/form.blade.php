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
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="Nome do participante" required>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email"
               @isset($participante->email) value="{{ $participante->email }}" @endisset
               id="email" name="email"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="email@exemplo.com (opcional)">
    </div>

    <div>
        <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">Contato</label>
        <input type="text"
               @isset($participante->telefone) value="{{ $participante->telefone }}" @endisset
               id="telefone" name="telefone"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="(67) 99999-9999 (opcional)">
    </div>

    <div class="flex items-center">
        <input type="checkbox"
               @isset($participante->is_whatsapp) @if($participante->is_whatsapp) checked @endif @endisset
               id="is_whatsapp" name="is_whatsapp" value="1"
               class="w-4 h-4 text-green-600 bg-white border-gray-300 rounded focus:ring-green-500 focus:ring-2">
        <label for="is_whatsapp" class="ml-2 text-sm font-medium text-gray-700">
            <i class="fab fa-whatsapp text-green-500 mr-1"></i>É WhatsApp?
        </label>
    </div>

    @if(isset($eventoId) && $eventoId)
        <!-- Campo oculto quando vem de um evento específico -->
        <input type="hidden" name="evento_id" value="{{ $eventoId }}">

        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex items-center">
                <i class="fas fa-calendar-alt text-blue-600 mr-3"></i>
                <div>
                    <span class="text-sm font-medium text-gray-700">Inscrevendo no evento:</span>
                    <p class="text-lg font-semibold text-gray-900">{{ $evento->nome ?? '' }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="flex gap-4">
        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-700 focus:shadow-outline focus:outline-none">
            {{ $submit }}
        </button>
        <a href="{{ isset($eventoId) && $eventoId ? '/eventos/' . $eventoId : '/participantes' }}"
           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-500 hover:bg-neutral-600 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-600 focus:shadow-outline focus:outline-none">
            Cancelar
        </a>
    </div>
</form>