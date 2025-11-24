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
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="Digite o nome do evento" required>
    </div>

    <div>
        <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
        <textarea id="descricao" name="descricao" rows="3"
                  class="flex w-full px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                  placeholder="Descreva o evento (opcional)">@isset($evento->descricao){{ $evento->descricao }}@endisset</textarea>
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
                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                placeholder="Selecione a data" readonly />
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
        <label for="local" class="block text-sm font-medium text-gray-700 mb-2">Local</label>
        <input type="text"
               @isset($evento->local) value="{{ $evento->local }}" @endisset
               id="local" name="local"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="Local do evento (opcional)">
    </div>

    <div>
        <label for="valor_ingresso" class="block text-sm font-medium text-gray-700 mb-2">Valor do Ingresso (R$)</label>
        <input type="number"
               @isset($evento->valor_ingresso) value="{{ $evento->valor_ingresso }}" @endisset
               id="valor_ingresso" name="valor_ingresso"
               step="0.01" min="0"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="0.00 (opcional - deixe vazio para eventos gratuitos)">
    </div>

    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status do Evento *</label>
        <select id="status" name="status" required
                class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50">
            <option value="rascunho" @isset($evento->status) @if($evento->status == 'rascunho') selected @endif @endisset>
                Rascunho - Criado mas não publicado
            </option>
            <option value="em_andamento" @isset($evento->status) @if($evento->status == 'em_andamento') selected @endif @endisset>
                Em Andamento - Publicado e aceitando inscrições
            </option>
            <option value="concluido" @isset($evento->status) @if($evento->status == 'concluido') selected @endif @endisset>
                Concluído - Evento já aconteceu
            </option>
        </select>
    </div>

    <div>
        <label for="capacidade" class="block text-sm font-medium text-gray-700 mb-2">Evento para quantas pessoas?</label>
        <input type="number"
               @isset($evento->capacidade) value="{{ $evento->capacidade }}" @endisset
               id="capacidade" name="capacidade"
               min="1"
               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
               placeholder="Ex: 50 (deixe vazio para sem limite)">
        <p class="text-xs text-gray-500 mt-1">Número máximo de participantes que podem se inscrever</p>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-950 hover:bg-neutral-900 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 focus:shadow-outline focus:outline-none">
            {{ $submit }}
        </button>
        <a href="/eventos" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-500 hover:bg-neutral-600 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-600 focus:shadow-outline focus:outline-none">
            Cancelar
        </a>
    </div>
</form>