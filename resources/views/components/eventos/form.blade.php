<form action="{{ $action }}" method="post" class="space-y-6">
    @csrf
    @isset($evento->id)
        @method('PUT')
        <input type="hidden" name="id" value="{{ $evento->id }}">
    @endisset

    <div>
        <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome do Evento <span class="text-red-600">*</span></label>
        <input type="text"
               @isset($evento->nome) value="{{ $evento->nome }}" @endisset
               id="nome" name="nome"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="" required>
    </div>

    <div>
        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
            Link da Landing Page <span class="text-gray-400 font-normal">(gerado automaticamente)</span>
        </label>
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500">{{ url('/') }}/</span>
            <input type="text"
                   @isset($evento->slug) value="{{ $evento->slug }}" @endisset
                   id="slug" name="slug"
                   class="flex-1 h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                   placeholder="">
        </div>
        <p class="text-xs text-gray-500 mt-1">
            <i class="fas fa-info-circle mr-1"></i>O link será gerado automaticamente baseado no nome do evento. Você pode editá-lo se desejar.
        </p>
        <p id="slug-error" class="text-xs text-red-600 mt-1 hidden">
            <i class="fas fa-exclamation-circle mr-1"></i>Este link já está em uso. Por favor, escolha outro.
        </p>
        <p id="slug-success" class="text-xs text-green-600 mt-1 hidden">
            <i class="fas fa-check-circle mr-1"></i>Este link está disponível.
        </p>
    </div>

    <div>
        <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">
            Descrição <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <textarea id="descricao" name="descricao" rows="3"
                  class="flex w-full px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                  placeholder="">@isset($evento->descricao){{ $evento->descricao }}@endisset</textarea>
    </div>

    <div x-data="{
        datePickerOpen: false,
        datePickerValue: '@isset($evento->data_evento){{ date('M d, Y', strtotime($evento->data_evento)) }}@endisset',
        datePickerValueForInput: '@isset($evento->data_evento){{ $evento->data_evento }}@endisset',
        datePickerFormat: 'M d, Y',
        datePickerMonth: '',
        datePickerYear: '',
        datePickerDay: '',
        datePickerDaysInMonth: [],
        datePickerBlankDaysInMonth: [],
        datePickerMonthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datePickerDays: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
        datePickerDayClicked(day) {
            let selectedDate = new Date(this.datePickerYear, this.datePickerMonth, day);
            this.datePickerDay = day;
            this.datePickerValue = this.datePickerFormatDate(selectedDate);
            this.datePickerValueForInput = this.datePickerFormatDateForInput(selectedDate);
            this.datePickerIsSelectedDate(day);
            this.datePickerOpen = false;
        },
        datePickerPreviousMonth(){
            if (this.datePickerMonth == 0) {
                this.datePickerYear--;
                this.datePickerMonth = 12;
            }
            this.datePickerMonth--;
            this.datePickerCalculateDays();
        },
        datePickerNextMonth(){
            if (this.datePickerMonth == 11) {
                this.datePickerMonth = 0;
                this.datePickerYear++;
            } else {
                this.datePickerMonth++;
            }
            this.datePickerCalculateDays();
        },
        datePickerIsSelectedDate(day) {
            const d = new Date(this.datePickerYear, this.datePickerMonth, day);
            return this.datePickerValue === this.datePickerFormatDate(d) ? true : false;
        },
        datePickerIsToday(day) {
            const today = new Date();
            const d = new Date(this.datePickerYear, this.datePickerMonth, day);
            return today.toDateString() === d.toDateString() ? true : false;
        },
        datePickerCalculateDays() {
            let daysInMonth = new Date(this.datePickerYear, this.datePickerMonth + 1, 0).getDate();
            let dayOfWeek = new Date(this.datePickerYear, this.datePickerMonth).getDay();
            let blankdaysArray = [];
            for (var i = 1; i <= dayOfWeek; i++) {
                blankdaysArray.push(i);
            }
            let daysArray = [];
            for (var i = 1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }
            this.datePickerBlankDaysInMonth = blankdaysArray;
            this.datePickerDaysInMonth = daysArray;
        },
        datePickerFormatDate(date) {
            let formattedDate = ('0' + date.getDate()).slice(-2);
            let formattedMonthShortName = this.datePickerMonthNames[date.getMonth()].substring(0, 3);
            let formattedYear = date.getFullYear();
            return `${formattedMonthShortName} ${formattedDate}, ${formattedYear}`;
        },
        datePickerFormatDateForInput(date) {
            let formattedDate = ('0' + date.getDate()).slice(-2);
            let formattedMonthInNumber = ('0' + (parseInt(date.getMonth()) + 1)).slice(-2);
            let formattedYear = date.getFullYear();
            return `${formattedYear}-${formattedMonthInNumber}-${formattedDate}`;
        },
        handleManualDateInput(event) {
            let input = event.target.value;
            // Remove non-numeric characters except /
            input = input.replace(/[^\d\/]/g, '');

            // Auto-format as user types: dd/mm/yyyy
            if (input.length === 2 && !input.includes('/')) {
                input = input + '/';
            } else if (input.length === 5 && input.split('/').length === 2) {
                input = input + '/';
            }

            // Limit to 10 characters (dd/mm/yyyy)
            if (input.length > 10) {
                input = input.substring(0, 10);
            }

            this.datePickerValue = input;

            // Try to parse the date if it's complete (dd/mm/yyyy)
            if (input.length === 10) {
                const parts = input.split('/');
                if (parts.length === 3) {
                    const day = parseInt(parts[0]);
                    const month = parseInt(parts[1]) - 1; // JS months are 0-indexed
                    const year = parseInt(parts[2]);

                    // Validate the date
                    const date = new Date(year, month, day);
                    if (date.getDate() === day && date.getMonth() === month && date.getFullYear() === year) {
                        this.datePickerDay = day;
                        this.datePickerMonth = month;
                        this.datePickerYear = year;
                        this.datePickerValueForInput = this.datePickerFormatDateForInput(date);
                        this.datePickerValue = this.datePickerFormatDate(date);
                        this.datePickerCalculateDays();
                    }
                }
            }
        },
    }" x-init="
        currentDate = new Date();
        if (datePickerValueForInput) {
            currentDate = new Date(datePickerValueForInput);
        }
        datePickerMonth = currentDate.getMonth();
        datePickerYear = currentDate.getFullYear();
        datePickerDay = currentDate.getDate();
        if (datePickerValueForInput) {
            datePickerValue = datePickerFormatDate(currentDate);
        }
        datePickerCalculateDays();
    ">
        <label class="block text-sm font-medium text-gray-700 mb-2">Data do Evento</label>
        <div class="relative">
            <input x-ref="datePickerInput" type="text" @click="datePickerOpen=!datePickerOpen"
                x-model="datePickerValue" x-on:keydown.escape="datePickerOpen=false"
                @input="handleManualDateInput($event)"
                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                placeholder="dd/mm/aaaa ou clique para selecionar" />
            <input type="hidden" name="data_evento" x-model="datePickerValueForInput">
            <div @click="datePickerOpen=!datePickerOpen; if(datePickerOpen){ $refs.datePickerInput.focus() }"
                class="absolute top-0 right-0 px-3 py-2 cursor-pointer text-neutral-400 hover:text-neutral-500">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div x-show="datePickerOpen" x-transition @click.away="datePickerOpen = false"
                class="absolute top-0 left-0 z-50 p-4 mt-12 antialiased bg-white border rounded-lg shadow w-[17rem] border-neutral-200/70">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <span x-text="datePickerMonthNames[datePickerMonth]" class="text-lg font-bold text-gray-800"></span>
                        <span x-text="datePickerYear" class="ml-1 text-lg font-normal text-gray-600"></span>
                    </div>
                    <div>
                        <button @click="datePickerPreviousMonth()" type="button" class="inline-flex p-1 rounded-full transition duration-100 ease-in-out cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                            <svg class="inline-flex w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click="datePickerNextMonth()" type="button" class="inline-flex p-1 rounded-full transition duration-100 ease-in-out cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                            <svg class="inline-flex w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-7 mb-3">
                    <template x-for="(day, index) in datePickerDays" :key="index">
                        <div class="px-0.5">
                            <div x-text="day" class="text-xs font-medium text-center text-gray-800"></div>
                        </div>
                    </template>
                </div>
                <div class="grid grid-cols-7">
                    <template x-for="blankDay in datePickerBlankDaysInMonth">
                        <div class="p-1 text-sm text-center border border-transparent"></div>
                    </template>
                    <template x-for="(day, dayIndex) in datePickerDaysInMonth" :key="dayIndex">
                        <div class="px-0.5 mb-1 aspect-square">
                            <div x-text="day" @click="datePickerDayClicked(day)"
                                :class="{
                                    'bg-neutral-200': datePickerIsToday(day) == true,
                                    'text-gray-600 hover:bg-neutral-200': datePickerIsToday(day) == false && datePickerIsSelectedDate(day) == false,
                                    'bg-neutral-800 text-white hover:bg-neutral-800/70': datePickerIsSelectedDate(day) == true
                                }"
                                class="flex justify-center items-center text-sm leading-none text-center rounded-full cursor-pointer w-full h-full">
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div>
        <label for="local" class="block text-sm font-medium text-gray-700 mb-2">
            Local <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <input type="text"
               @isset($evento->local) value="{{ $evento->local }}" @endisset
               id="local" name="local"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="">
    </div>

    <div>
        <label for="endereco" class="block text-sm font-medium text-gray-700 mb-2">
            Endereço <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <input type="text"
               @isset($evento->endereco) value="{{ $evento->endereco }}" @endisset
               id="endereco" name="endereco"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder=""
               autocomplete="off">
        <p class="text-xs text-gray-500 mt-1">
            <i class="fas fa-info-circle mr-1"></i>Digite o endereço completo ou nome do estabelecimento
        </p>
    </div>


    <div>
        <label for="hora_evento" class="block text-sm font-medium text-gray-700 mb-2">
            Hora do Evento <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <input type="time"
               @isset($evento->hora_evento) value="{{ $evento->hora_evento }}" @endisset
               id="hora_evento" name="hora_evento"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="">
    </div>

    <div>
        <label for="valor_ingresso" class="block text-sm font-medium text-gray-700 mb-2">
            Valor do Ingresso (R$) <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <input type="number"
               @isset($evento->valor_ingresso) value="{{ $evento->valor_ingresso }}" @endisset
               id="valor_ingresso" name="valor_ingresso"
               step="0.01" min="0"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="">
    </div>

    <div>
        <label for="custo_por_pessoa" class="block text-sm font-medium text-gray-700 mb-2">
            Custo por Pessoa (R$) <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <input type="number"
               @isset($evento->custo_por_pessoa) value="{{ $evento->custo_por_pessoa }}" @endisset
               id="custo_por_pessoa" name="custo_por_pessoa"
               step="0.01" min="0"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="">
        <p class="text-xs text-gray-500 mt-1">Custo estimado do evento por participante</p>
    </div>

    <div>
        <label for="capacidade" class="block text-sm font-medium text-gray-700 mb-2">
            Evento para quantas pessoas? <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <input type="number"
               @isset($evento->capacidade) value="{{ $evento->capacidade }}" @endisset
               id="capacidade" name="capacidade"
               min="1"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="">
        <p class="text-xs text-gray-500 mt-1">Número máximo de participantes que podem se inscrever</p>
    </div>

    <div>
        <label for="whatsapp_oficial" class="block text-sm font-medium text-gray-700 mb-2">
            WhatsApp Oficial <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <input type="text"
               @isset($evento->whatsapp_oficial) value="{{ $evento->whatsapp_oficial }}" @endisset
               id="whatsapp_oficial" name="whatsapp_oficial"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="">
        <p class="text-xs text-gray-500 mt-1">Número de WhatsApp para contato sobre o evento</p>
    </div>

    <div>
        <label for="observacoes" class="block text-sm font-medium text-gray-700 mb-2">
            Observações <span class="text-gray-400 font-normal">(opcional)</span>
        </label>
        <textarea id="observacoes" name="observacoes" rows="4"
                  class="flex w-full px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                  placeholder="">@isset($evento->observacoes){{ $evento->observacoes }}@endisset</textarea>
    </div>

    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status do Evento <span class="text-red-600">*</span></label>
        <select id="status" name="status" required
                class="flex w-full h-10 px-4 pr-12 py-2 text-sm bg-white border rounded-lg border-gray-300 ring-offset-background placeholder:text-gray-500 focus:border-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 disabled:cursor-not-allowed disabled:opacity-50 appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e')] bg-[length:1.2em] bg-[right_0.7rem_center] bg-no-repeat hover:border-gray-400 transition-colors">
            <option value="rascunho" @isset($evento->status) @if($evento->status == 'rascunho') selected @endif @endisset>
                Rascunho
            </option>
            <option value="publicado" @isset($evento->status) @if($evento->status == 'publicado') selected @endif @endisset>
                Publicado
            </option>
            <option value="inscricoes_encerradas" @isset($evento->status) @if($evento->status == 'inscricoes_encerradas') selected @endif @endisset>
                Inscrições Encerradas
            </option>
            <option value="finalizado" @isset($evento->status) @if($evento->status == 'finalizado') selected @endif @endisset>
                Finalizado
            </option>
            <option value="cancelado" @isset($evento->status) @if($evento->status == 'cancelado') selected @endif @endisset>
                Cancelado
            </option>
        </select>
    </div>

    <div class="flex gap-4 justify-end">
        <a href="/eventos" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-500 hover:bg-neutral-600 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-600 focus:shadow-outline focus:outline-none">
            Cancelar
        </a>
        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-950 hover:bg-neutral-900 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 focus:shadow-outline focus:outline-none">
            {{ $submit }}
        </button>
    </div>
</form>

<script>
    // Google Places Autocomplete
    console.log('Autocomplete script loaded');

    function initEventoAutocomplete() {
        console.log('Initializing autocomplete...');

        const enderecoInput = document.getElementById('endereco');
        const localInput = document.getElementById('local');

        console.log('Endereco input:', enderecoInput);
        console.log('Local input:', localInput);

        if (typeof google !== 'undefined' && google.maps && google.maps.places) {
            console.log('Google Maps API loaded successfully');

            try {
                // Initialize autocomplete for endereco field
                const autocomplete = new google.maps.places.Autocomplete(enderecoInput, {
                    componentRestrictions: { country: 'br' },
                    fields: ['formatted_address', 'name', 'geometry']
                });
                console.log('Endereco autocomplete initialized');

                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();
                    console.log('Place selected for endereco:', place);

                    if (place.formatted_address) {
                        enderecoInput.value = place.formatted_address;
                    }
                    if (place.name && !localInput.value) {
                        localInput.value = place.name;
                    }
                });

                // Initialize autocomplete for local field (for establishment names)
                const localAutocomplete = new google.maps.places.Autocomplete(localInput, {
                    componentRestrictions: { country: 'br' },
                    types: ['establishment'],
                    fields: ['name', 'formatted_address', 'geometry']
                });
                console.log('Local autocomplete initialized');

                localAutocomplete.addListener('place_changed', function() {
                    const place = localAutocomplete.getPlace();
                    console.log('Place selected for local:', place);

                    if (place.name) {
                        localInput.value = place.name;
                    }
                    if (place.formatted_address && !enderecoInput.value) {
                        enderecoInput.value = place.formatted_address;
                    }
                });
            } catch (error) {
                console.error('Error initializing autocomplete:', error);
            }
        } else {
            console.warn('Google Maps API not loaded yet. Retrying in 500ms...');
            setTimeout(initEventoAutocomplete, 500);
        }
    }

    // Initialize when page is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing autocomplete');
            initEventoAutocomplete();
        });
    } else {
        console.log('DOM already loaded, initializing autocomplete now');
        initEventoAutocomplete();
    }
</script>

<script>
    // Geração automática e validação de slug
    const nomeInput = document.getElementById('nome');
    const slugInput = document.getElementById('slug');
    const slugError = document.getElementById('slug-error');
    const slugSuccess = document.getElementById('slug-success');
    const eventoId = document.querySelector('input[name="id"]')?.value || null;

    let slugCheckTimeout = null;
    let manualSlugEdit = false;

    // Função para converter texto em slug
    function gerarSlug(texto) {
        return texto
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '') // Remove acentos
            .replace(/[^\w\s-]/g, '') // Remove caracteres especiais
            .replace(/\s+/g, '-') // Substitui espaços por hífens
            .replace(/-+/g, '-') // Remove hífens duplicados
            .replace(/^-+|-+$/g, ''); // Remove hífens do início e fim
    }

    // Função para verificar se o slug já existe
    async function verificarSlug(slug) {
        if (!slug) {
            slugError.classList.add('hidden');
            slugSuccess.classList.add('hidden');
            return;
        }

        try {
            const url = new URL('{{ route("eventos.verificar-slug") }}');
            url.searchParams.append('slug', slug);
            if (eventoId) {
                url.searchParams.append('evento_id', eventoId);
            }

            const response = await fetch(url);
            const data = await response.json();

            if (data.existe) {
                slugError.classList.remove('hidden');
                slugSuccess.classList.add('hidden');
                slugInput.classList.add('border-red-500');
                slugInput.classList.remove('border-green-500');
            } else {
                slugError.classList.add('hidden');
                slugSuccess.classList.remove('hidden');
                slugInput.classList.remove('border-red-500');
                slugInput.classList.add('border-green-500');
            }
        } catch (error) {
            console.error('Erro ao verificar slug:', error);
        }
    }

    // Quando o nome do evento mudar, gerar slug automaticamente (se não foi editado manualmente)
    nomeInput.addEventListener('input', function() {
        if (!manualSlugEdit) {
            const novoSlug = gerarSlug(this.value);
            slugInput.value = novoSlug;

            // Limpar timeout anterior
            if (slugCheckTimeout) {
                clearTimeout(slugCheckTimeout);
            }

            // Verificar slug após 500ms sem digitar
            slugCheckTimeout = setTimeout(() => {
                verificarSlug(novoSlug);
            }, 500);
        }
    });

    // Quando o slug for editado manualmente
    slugInput.addEventListener('input', function() {
        manualSlugEdit = true;
        const slug = gerarSlug(this.value);
        this.value = slug;

        // Limpar timeout anterior
        if (slugCheckTimeout) {
            clearTimeout(slugCheckTimeout);
        }

        // Verificar slug após 500ms sem digitar
        slugCheckTimeout = setTimeout(() => {
            verificarSlug(slug);
        }, 500);
    });

    // Verificar slug inicial se estiver editando
    if (slugInput.value) {
        manualSlugEdit = true;
        verificarSlug(slugInput.value);
    }

    // Prevenir submissão do formulário se o slug já existir
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!slugError.classList.contains('hidden')) {
            e.preventDefault();
            alert('O link da landing page já está em uso. Por favor, escolha outro.');
            slugInput.focus();
        }
    });
</script>