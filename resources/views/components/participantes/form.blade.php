<form action="{{ $action }}" method="post" class="space-y-6">
    @csrf
    @isset($participante->id)
        @method('PUT')
        <input type="hidden" name="id" value="{{ $participante->id }}">
    @endisset

    <div>
        <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome <span class="text-red-600">*</span></label>
        <input type="text"
               @isset($participante->nome) value="{{ $participante->nome }}" @endisset
               id="nome" name="nome"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="" required>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Email <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <input type="email"
               @isset($participante->email) value="{{ $participante->email }}" @endisset
               id="email" name="email"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="">
    </div>

    <div>
        <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">
            Contato <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <input type="text"
               @isset($participante->telefone) value="{{ $participante->telefone }}" @endisset
               id="telefone" name="telefone"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="">
        <div class="flex items-center mt-2">
            <input type="checkbox"
                   @isset($participante->is_whatsapp) @if($participante->is_whatsapp) checked @endif @endisset
                   id="is_whatsapp" name="is_whatsapp" value="1"
                   class="w-4 h-4 text-green-600 bg-white border-gray-300 rounded focus:ring-green-500 focus:ring-2">
            <label for="is_whatsapp" class="ml-2 text-sm font-medium text-gray-700">
                <i class="fab fa-whatsapp text-green-500 mr-1"></i>É WhatsApp?
            </label>
        </div>
    </div>

    <div>
        <label for="sexo" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-venus-mars mr-1 text-pink-600"></i>Sexo <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <select id="sexo" name="sexo"
                class="flex w-full h-10 px-4 pr-12 py-2 text-sm bg-white border rounded-lg border-gray-300 ring-offset-background focus:border-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e')] bg-[length:1.2em] bg-[right_0.7rem_center] bg-no-repeat hover:border-gray-400 transition-colors">
            <option value=""></option>
            <option value="M" @isset($participante->sexo) @if($participante->sexo === 'M') selected @endif @endisset>Masculino</option>
            <option value="F" @isset($participante->sexo) @if($participante->sexo === 'F') selected @endif @endisset>Feminino</option>
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="data_nascimento" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-calendar mr-1 text-blue-600"></i>Data Nascimento <span class="text-gray-400 font-normal">(opcional)</span>
            </label>
            <input type="date"
                   @isset($participante->data_nascimento) value="{{ $participante->data_nascimento->format('Y-m-d') }}" @endisset
                   id="data_nascimento" name="data_nascimento"
                   class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">
        </div>

        <div>
            <label for="idade" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-birthday-cake mr-1 text-purple-600"></i>Idade <span class="text-gray-400 font-normal">(opcional)</span>
            </label>
            <input type="number"
                   @isset($participante->idade) value="{{ $participante->idade }}" @endisset
                   id="idade" name="idade" min="0" max="150"
                   class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                   placeholder="">
        </div>
    </div>

    <script>
        // Auto-calcular idade a partir da data de nascimento
        document.getElementById('data_nascimento').addEventListener('change', function() {
            const dataNascimento = new Date(this.value);
            const hoje = new Date();

            if (this.value && dataNascimento <= hoje) {
                let idade = hoje.getFullYear() - dataNascimento.getFullYear();
                const mes = hoje.getMonth() - dataNascimento.getMonth();

                if (mes < 0 || (mes === 0 && hoje.getDate() < dataNascimento.getDate())) {
                    idade--;
                }

                document.getElementById('idade').value = idade;
            }
        });
    </script>

    <div>
        <label for="observacoes" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-sticky-note mr-1 text-yellow-600"></i>Observações <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <textarea id="observacoes" name="observacoes" rows="4"
                  class="flex w-full px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                  placeholder="">@isset($participante->observacoes){{ $participante->observacoes }}@endisset</textarea>
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

    <div class="flex gap-4 justify-end">
        <a href="{{ isset($eventoId) && $eventoId ? '/eventos/' . $eventoId : '/participantes' }}"
           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-500 hover:bg-neutral-600 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-600 focus:shadow-outline focus:outline-none">
            Cancelar
        </a>
        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-700 focus:shadow-outline focus:outline-none">
            {{ $submit }}
        </button>
    </div>
</form>