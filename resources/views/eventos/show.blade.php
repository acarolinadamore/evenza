@extends('layouts.app')

@section('titulo', 'Detalhes do Evento')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <a href="/eventos"
                   class="inline-flex items-center justify-center w-10 h-10 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 focus:outline-none"
                   title="Voltar">
                    <i class="fas fa-chevron-left text-xl"></i>
                </a>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-bold text-gray-800 font-sans">{{ $evento->nome }}</h1>
                    @if($evento->status == 'rascunho')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            Rascunho
                        </span>
                    @elseif($evento->status == 'publicado')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Publicado
                        </span>
                    @elseif($evento->status == 'inscricoes_encerradas')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Inscrições Encerradas
                        </span>
                    @elseif($evento->status == 'finalizado')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Finalizado
                        </span>
                    @elseif($evento->status == 'cancelado')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Cancelado
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('eventos.landing-page.edit', $evento) }}"
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 focus:shadow-outline focus:outline-none">
                    Landing Page
                </a>
                <a href="/eventos/editar/{{ $evento->id }}"
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-yellow-500 rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600 focus:shadow-outline focus:outline-none">
                    <i class="fas fa-edit mr-2"></i>Editar Evento
                </a>
            </div>
        </div>

        <!-- Cards de Informações -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
            <!-- Card Data -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-alt text-red-600 text-lg"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Data</h3>
                </div>
                @if($evento->data_evento)
                    <div class="text-base font-normal text-gray-900 mb-2">
                        {{ date('d/m/Y', strtotime($evento->data_evento)) }}
                    </div>
                    @php
                        $dataEvento = \Carbon\Carbon::parse($evento->data_evento)->startOfDay();
                        $hoje = \Carbon\Carbon::now()->startOfDay();
                        $diasRestantes = (int) $hoje->diffInDays($dataEvento, false);
                    @endphp
                    @if($diasRestantes > 0)
                        @if($diasRestantes <= 7)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Faltam {{ $diasRestantes }} dia{{ $diasRestantes > 1 ? 's' : '' }}
                            </span>
                        @elseif($diasRestantes <= 30)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Faltam {{ $diasRestantes }} dia{{ $diasRestantes > 1 ? 's' : '' }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Faltam {{ $diasRestantes }} dia{{ $diasRestantes > 1 ? 's' : '' }}
                            </span>
                        @endif
                    @elseif($diasRestantes == 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Hoje
                        </span>
                    @endif
                @else
                    <div class="text-sm font-normal text-gray-700 mb-1">
                        Não definida
                    </div>
                @endif
            </div>

            <!-- Card Hora -->
            @if($evento->hora_evento)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-clock text-orange-600 text-lg"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Hora</h3>
                </div>
                <div class="text-base font-normal text-gray-900">
                    {{ date('H:i', strtotime($evento->hora_evento)) }}
                </div>
            </div>
            @endif

            <!-- Card Local -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-blue-600 text-lg"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Local</h3>
                </div>
                @if($evento->local)
                <div class="flex items-start justify-between gap-2 mb-2">
                    <p class="text-sm text-gray-700 leading-snug flex-1" title="{{ $evento->local }}" id="localTexto">
                        {{ Str::limit($evento->local, 50) }}
                    </p>
                    <button onclick="copiarLocal()" title="Copiar local"
                            class="text-blue-500 hover:text-blue-700 transition-colors flex-shrink-0">
                        <i class="fas fa-copy text-sm"></i>
                    </button>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($evento->local) }}"
                   target="_blank"
                   class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 font-medium">
                    <i class="fas fa-external-link-alt mr-1"></i>Ver no Google Maps
                </a>
                @else
                <p class="text-sm text-gray-500">Local não informado</p>
                @endif
            </div>

            <!-- Card Participantes -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-users text-green-600 text-lg"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Participantes</h3>
                </div>
                @if($evento->capacidade)
                    <div class="text-lg font-normal text-gray-900 mb-1">
                        <span class="text-gray-900">{{ $evento->participantes->count() }}</span><span class="text-gray-400">/{{ $evento->capacidade }}</span>
                    </div>
                @else
                    <div class="text-sm font-normal text-gray-700 mb-1">
                        {{ $evento->participantes->count() }} inscrito{{ $evento->participantes->count() != 1 ? 's' : '' }}
                    </div>
                @endif
                @if($evento->capacidade)
                    @php
                        $inscritos = $evento->participantes->count();
                        $percentual = ($inscritos / $evento->capacidade) * 100;
                        $vagasRestantes = $evento->capacidade - $inscritos;
                    @endphp
                    <div class="text-sm mt-1">
                        @if($percentual >= 100)
                            <span class="text-red-600 font-semibold">Esgotado</span>
                        @elseif($percentual >= 80)
                            <span class="text-yellow-600">{{ $vagasRestantes }} vaga{{ $vagasRestantes != 1 ? 's' : '' }} restante{{ $vagasRestantes != 1 ? 's' : '' }}</span>
                        @else
                            <span class="text-green-600">{{ $vagasRestantes }} vaga{{ $vagasRestantes != 1 ? 's' : '' }} restante{{ $vagasRestantes != 1 ? 's' : '' }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Card Valor -->
            @if($evento->valor_ingresso || $evento->custo_por_pessoa)
            @php
                $totalInscritos = $evento->participantes->count();
                $receitaTotal = $evento->valor_ingresso ? $evento->valor_ingresso * $totalInscritos : 0;
                $custoTotal = $evento->custo_por_pessoa ? $evento->custo_por_pessoa * $totalInscritos : 0;
                $saldoEstimado = $receitaTotal - $custoTotal;
            @endphp
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow relative">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-dollar-sign text-purple-600 text-lg"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800">Valores</h3>
                    </div>
                    @if($totalInscritos > 0)
                    <button onclick="toggleValoresDetalhes()" class="text-purple-600 hover:text-purple-800 transition-colors">
                        <i class="fas fa-calculator text-lg"></i>
                    </button>
                    @endif
                </div>

                @if($evento->valor_ingresso)
                    <div class="mb-2">
                        <p class="text-xs text-gray-500 mb-1">Ingresso (por pessoa)</p>
                        <div class="text-base font-semibold text-green-600">
                            R$ {{ number_format($evento->valor_ingresso, 2, ',', '.') }}
                        </div>
                    </div>
                @endif

                @if($evento->custo_por_pessoa)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Custo por Pessoa</p>
                        <div class="text-base font-semibold text-red-600">
                            R$ {{ number_format($evento->custo_por_pessoa, 2, ',', '.') }}
                        </div>
                    </div>
                @endif

                <!-- Popover de Detalhes -->
                @if($totalInscritos > 0)
                <div id="valoresDetalhes" class="hidden absolute top-full right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border-2 border-purple-200 p-4 z-50">
                    <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-200">
                        <h4 class="text-sm font-bold text-gray-800">Cálculos Detalhados</h4>
                        <button onclick="toggleValoresDetalhes()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    @if($evento->valor_ingresso)
                    <div class="mb-3 pb-3 border-b border-gray-100">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-600">Ingresso por pessoa</span>
                            <span class="text-sm font-semibold text-gray-800">R$ {{ number_format($evento->valor_ingresso, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-600">× {{ $totalInscritos }} inscrito{{ $totalInscritos > 1 ? 's' : '' }}</span>
                            <span class="text-sm text-gray-600">= R$ {{ number_format($receitaTotal, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mt-2 pt-2 border-t border-green-100">
                            <span class="text-xs font-semibold text-green-700">Receita Total</span>
                            <span class="text-base font-bold text-green-600">R$ {{ number_format($receitaTotal, 2, ',', '.') }}</span>
                        </div>
                    </div>
                    @endif

                    @if($evento->custo_por_pessoa)
                    <div class="mb-3 pb-3 border-b border-gray-100">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-600">Custo por pessoa</span>
                            <span class="text-sm font-semibold text-gray-800">R$ {{ number_format($evento->custo_por_pessoa, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-600">× {{ $totalInscritos }} inscrito{{ $totalInscritos > 1 ? 's' : '' }}</span>
                            <span class="text-sm text-gray-600">= R$ {{ number_format($custoTotal, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mt-2 pt-2 border-t border-red-100">
                            <span class="text-xs font-semibold text-red-700">Custo Total</span>
                            <span class="text-base font-bold text-red-600">R$ {{ number_format($custoTotal, 2, ',', '.') }}</span>
                        </div>
                    </div>
                    @endif

                    @if($evento->valor_ingresso && $evento->custo_por_pessoa)
                    <div class="bg-{{ $saldoEstimado >= 0 ? 'green' : 'red' }}-50 rounded-lg p-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-800">Saldo Estimado</span>
                            <span class="text-xl font-bold {{ $saldoEstimado >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                R$ {{ number_format($saldoEstimado, 2, ',', '.') }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">
                            {{ $saldoEstimado >= 0 ? 'Lucro estimado' : 'Prejuízo estimado' }} com {{ $totalInscritos }} inscrito{{ $totalInscritos > 1 ? 's' : '' }}
                        </p>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <script>
                function toggleValoresDetalhes() {
                    const detalhes = document.getElementById('valoresDetalhes');
                    detalhes.classList.toggle('hidden');
                }

                // Fechar ao clicar fora
                document.addEventListener('click', function(event) {
                    const detalhes = document.getElementById('valoresDetalhes');
                    const isClickInside = event.target.closest('#valoresDetalhes') ||
                                         event.target.closest('button[onclick="toggleValoresDetalhes()"]');

                    if (!isClickInside && !detalhes.classList.contains('hidden')) {
                        detalhes.classList.add('hidden');
                    }
                });
            </script>
            @endif

            <!-- Card Descrição -->
            @php
                // Calcular quantas colunas a descrição deve ocupar
                $colunasOcupadas = 3; // Data, Local, Participantes (sempre presentes)
                if($evento->hora_evento) $colunasOcupadas++;
                if($evento->valor_ingresso || $evento->custo_por_pessoa) $colunasOcupadas++;
                $colunasDescricao = 6 - $colunasOcupadas;
            @endphp
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow col-span-1 md:col-span-2 lg:col-span-{{ $colunasDescricao }}">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-align-left text-indigo-600 text-lg"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Descrição</h3>
                </div>
                <p class="text-sm text-gray-700 leading-snug line-clamp-2" title="{{ $evento->descricao ?: 'Sem descrição' }}">
                    {{ $evento->descricao ?: 'Sem descrição' }}
                </p>
            </div>
        </div>

        <!-- Bloco Observações -->
        @if($evento->observacoes)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-info-circle text-gray-600 text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Observações</h3>
            </div>
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $evento->observacoes }}</p>
        </div>
        @endif

        <!-- Card Link Landing Page -->
        @if($evento->slug && $evento->landing_page_ativa)
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg shadow-sm border border-blue-200 p-6 mb-8">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-link text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Link da Landing Page</h3>
                    <p class="text-sm text-gray-600">Compartilhe este link para divulgar seu evento</p>
                </div>
            </div>
            <div class="flex gap-2">
                <input type="text"
                       value="{{ url('/' . $evento->slug) }}"
                       readonly
                       class="flex-1 px-4 py-3 text-sm bg-white border rounded-lg border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono"
                       id="linkPublico">
                <button onclick="copiarLink()"
                        class="inline-flex items-center justify-center px-6 py-3 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:shadow-outline focus:outline-none">
                    <i class="fas fa-copy mr-2"></i>Copiar
                </button>
                <a href="/{{ $evento->slug }}"
                   target="_blank"
                   class="inline-flex items-center justify-center px-6 py-3 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-lg bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-700 focus:shadow-outline focus:outline-none">
                    <i class="fas fa-external-link-alt mr-2"></i>Abrir
                </a>
            </div>
        </div>
        @elseif($evento->slug && !$evento->landing_page_ativa)
        <div class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200 p-6 mb-8">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Landing Page Inativa</h3>
                    <p class="text-sm text-gray-600 mt-1">Ative a landing page para compartilhar o link do evento</p>
                    <a href="{{ route('eventos.landing-page.edit', $evento) }}"
                       class="inline-flex items-center mt-3 text-sm font-medium text-yellow-700 hover:text-yellow-800">
                        <i class="fas fa-cog mr-2"></i>Configurar Landing Page
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Lista de Participantes -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Participantes Inscritos</h2>
            <a href="/participantes/novo?evento_id={{ $evento->id }}"
               class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-700 focus:shadow-outline focus:outline-none">
                <i class="fas fa-user-plus mr-2"></i>Adicionar Participante
            </a>
        </div>

        @if($evento->participantes->count() > 0)
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-neutral-200" style="table-layout: fixed;">
                            <thead class="bg-neutral-50">
                                <tr class="text-neutral-500">
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase cursor-pointer hover:bg-neutral-100" style="width: 20%;" onclick="sortTableEvento(0)">
                                        Nome <i class="fas fa-sort ml-1" id="sortIconE0"></i>
                                    </th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 18%;">Email</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 15%;">Contato</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 12%;">Idade</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 10%;">Sexo</th>
                                    <th class="px-5 py-3 text-xs font-medium text-right uppercase" style="width: 25%;">
                                        <span class="inline-block mr-12">Ações</span>
                                    </th>
                                </tr>
                                <tr class="bg-white">
                                    <th class="px-3 py-3">
                                        <input type="text" id="searchNomeEvento" placeholder="Buscar nome..."
                                               class="w-full px-3 py-2 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </th>
                                    <th class="px-3 py-3">
                                        <input type="text" id="searchEmailEvento" placeholder="Buscar email..."
                                               class="w-full px-3 py-2 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </th>
                                    <th class="px-3 py-3">
                                        <input type="text" id="searchContatoEvento" placeholder="Buscar contato..."
                                               class="w-full px-3 py-2 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </th>
                                    <th class="px-2 py-3">
                                        <div class="flex gap-1">
                                            <input type="number" id="searchIdadeMinEvento" placeholder="Min" min="0" max="150"
                                                   class="w-1/2 px-1 py-1 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                            <input type="number" id="searchIdadeMaxEvento" placeholder="Max" min="0" max="150"
                                                   class="w-1/2 px-1 py-1 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                        </div>
                                    </th>
                                    <th class="px-2 py-3">
                                        <select id="searchSexoEvento" style="
                                            background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%23666%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e');
                                            background-repeat: no-repeat;
                                            background-position: right 0.5rem center;
                                            background-size: 1.2em;
                                            padding-right: 2rem;
                                        " class="w-full h-9 px-3 py-2 text-xs font-normal bg-gray-50 border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-blue-500 hover:bg-white hover:border-gray-300 transition-all cursor-pointer appearance-none">
                                            <option value="" class="bg-white py-2 px-3 hover:bg-blue-50">Todos</option>
                                            <option value="M" class="bg-white py-2 px-3 hover:bg-blue-50">M</option>
                                            <option value="F" class="bg-white py-2 px-3 hover:bg-blue-50">F</option>
                                            <option value="" class="bg-white py-2 px-3 hover:bg-blue-50">Não Informado</option>
                                        </select>
                                    </th>
                                    <th class="px-3 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200" id="participantesEventoTableBody">
                                <tr id="noResultsRowEvento" style="display: none;">
                                    <td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">
                                        Nenhum resultado encontrado
                                    </td>
                                </tr>
                                @foreach ($evento->participantes as $participante)
                                <tr class="text-neutral-800 hover:bg-neutral-50 data-row"
                                    data-idade="{{ $participante->idade ?: '' }}"
                                    data-sexo="{{ $participante->sexo ?: '' }}">
                                    <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $participante->nome }}</td>
                                    <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $participante->email ?: '' }}</td>
                                    <td class="px-5 py-4 text-sm whitespace-nowrap">
                                        @if($participante->telefone)
                                            @php
                                                // Formatar telefone: (XX) XXXXX-XXXX ou (XX) XXXX-XXXX
                                                $tel = preg_replace('/\D/', '', $participante->telefone);
                                                if (strlen($tel) == 11) {
                                                    $telFormatado = '(' . substr($tel, 0, 2) . ') ' . substr($tel, 2, 5) . '-' . substr($tel, 7);
                                                } elseif (strlen($tel) == 10) {
                                                    $telFormatado = '(' . substr($tel, 0, 2) . ') ' . substr($tel, 2, 4) . '-' . substr($tel, 6);
                                                } else {
                                                    $telFormatado = $participante->telefone;
                                                }
                                            @endphp
                                            {{ $telFormatado }}
                                            @if($participante->is_whatsapp)
                                                <i class="fab fa-whatsapp text-green-500 ml-1"></i>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $participante->idade ?: '' }}</td>
                                    <td class="px-5 py-4 text-sm whitespace-nowrap">
                                        @if($participante->sexo == 'M')
                                            M
                                        @elseif($participante->sexo == 'F')
                                            F
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <a href="/participantes/editar/{{ $participante->id }}"
                                           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-yellow-500 rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600 focus:shadow-outline focus:outline-none mr-2">
                                            Editar
                                        </a>
                                        <form action="/participantes/excluir" method="post" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $participante->id }}">
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-red-600 rounded-md hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:shadow-outline focus:outline-none"
                                                    onclick="return confirm('Deseja excluir este participante?')">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="p-12 text-center text-gray-500">
            <i class="fas fa-users text-6xl mb-4 text-gray-300"></i>
            <p class="text-lg">Nenhum participante inscrito ainda.</p>
            <a href="/participantes/novo?evento_id={{ $evento->id }}"
               class="inline-flex items-center justify-center px-4 py-2 mt-4 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-700 focus:shadow-outline focus:outline-none">
                <i class="fas fa-user-plus mr-2"></i>Adicionar Primeiro Participante
            </a>
        </div>
        @endif
    </div>

    <!-- Lista de Organizadores -->
    <div class="bg-white rounded-lg shadow overflow-hidden mt-8">
        <div class="p-6 border-b flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Organizadores do Evento</h2>
            <a href="{{ route('eventos.organizadores.index', $evento) }}"
               class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-purple-600 hover:bg-purple-700 focus:ring-2 focus:ring-offset-2 focus:ring-purple-700 focus:shadow-outline focus:outline-none">
                <i class="fas fa-user-plus mr-2"></i>Adicionar Organizador
            </a>
        </div>

        @if($evento->organizadores->count() > 0)
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-neutral-200" style="table-layout: fixed;" id="organizadoresTable">
                            <thead class="bg-neutral-50">
                                <tr class="text-neutral-500">
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 25%;">Nome</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 20%;">Função</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 25%;">Email</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 15%;">Contato</th>
                                    <th class="px-5 py-3 text-xs font-medium text-right uppercase" style="width: 15%;">
                                        <span class="inline-block mr-12">Ações</span>
                                    </th>
                                </tr>
                                <tr class="bg-white">
                                    <th class="px-2 py-3">
                                        <input type="text" id="searchNomeOrg" placeholder="Filtrar por nome..."
                                               class="w-full px-3 py-2 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </th>
                                    <th class="px-2 py-3">
                                        <input type="text" id="searchCargoOrg" placeholder="Filtrar por função..."
                                               class="w-full px-3 py-2 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </th>
                                    <th class="px-2 py-3">
                                        <input type="text" id="searchEmailOrg" placeholder="Filtrar por email..."
                                               class="w-full px-3 py-2 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </th>
                                    <th class="px-2 py-3">
                                        <input type="text" id="searchContatoOrg" placeholder="Filtrar por contato..."
                                               class="w-full px-3 py-2 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </th>
                                    <th class="px-2 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                                @foreach ($evento->organizadores as $organizador)
                                <tr class="text-neutral-800 hover:bg-neutral-50">
                                    <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $organizador->nome }}</td>
                                    <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $organizador->cargo }}</td>
                                    <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $organizador->email }}</td>
                                    <td class="px-5 py-4 text-sm whitespace-nowrap">
                                        @if($organizador->telefone)
                                            {{ $organizador->telefone }}
                                            @if($organizador->is_whatsapp)
                                                <i class="fab fa-whatsapp text-green-500 ml-1"></i>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <a href="{{ route('eventos.organizadores.index', $evento) }}"
                                           class="inline-flex items-center justify-center w-20 px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-yellow-500 rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600 focus:shadow-outline focus:outline-none mr-2">
                                            Editar
                                        </a>
                                        <form action="{{ route('eventos.organizadores.destroy', [$evento, $organizador]) }}" method="post" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center w-20 px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-red-600 rounded-md hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:shadow-outline focus:outline-none"
                                                    onclick="return confirm('Deseja excluir este organizador?')">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="p-12 text-center text-gray-500">
            <i class="fas fa-users-cog text-6xl mb-4 text-gray-300"></i>
            <p class="text-sm text-gray-500">Nenhum organizador cadastrado ainda.</p>
            <a href="{{ route('eventos.organizadores.index', $evento) }}"
               class="inline-flex items-center justify-center px-4 py-2 mt-4 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-purple-600 hover:bg-purple-700 focus:ring-2 focus:ring-offset-2 focus:ring-purple-700 focus:shadow-outline focus:outline-none">
                <i class="fas fa-user-plus mr-2"></i>Adicionar Primeiro Organizador
            </a>
        </div>
        @endif
    </div>
</div>

<script>
function copiarLink() {
    const input = document.getElementById('linkPublico');
    input.select();
    input.setSelectionRange(0, 99999);

    // Usar API moderna de clipboard se disponível
    if (navigator.clipboard) {
        navigator.clipboard.writeText(input.value).then(() => {
            mostrarToast('Link copiado!', 'success');
        });
    } else {
        document.execCommand('copy');
        mostrarToast('Link copiado!', 'success');
    }
}

function copiarLocal() {
    const localCompleto = '{{ $evento->local }}';

    if (navigator.clipboard) {
        navigator.clipboard.writeText(localCompleto).then(() => {
            mostrarToast('Local copiado!', 'success');
        });
    } else {
        // Fallback para navegadores antigos
        const textarea = document.createElement('textarea');
        textarea.value = localCompleto;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        mostrarToast('Local copiado!', 'success');
    }
}

function mostrarToast(mensagem, tipo = 'success') {
    const toast = document.createElement('div');
    const bgColor = tipo === 'success' ? 'bg-green-500' : 'bg-blue-500';
    toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300`;
    toast.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${mensagem}`;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}

let sortDirectionsE = [0]; // 0 = não ordenado, 1 = crescente, -1 = decrescente

function sortTableEvento(columnIndex) {
    const tableBody = document.getElementById('participantesEventoTableBody');
    if (!tableBody) return;

    const rows = Array.from(tableBody.getElementsByTagName('tr')).filter(row => row.classList.contains('data-row'));
    const sortIcon = document.getElementById('sortIconE' + columnIndex);

    // Atualizar direção da ordenação
    sortDirectionsE[columnIndex] = sortDirectionsE[columnIndex] === 1 ? -1 : 1;

    // Atualizar ícone
    sortIcon.className = sortDirectionsE[columnIndex] === 1 ? 'fas fa-sort-up ml-1' : 'fas fa-sort-down ml-1';

    rows.sort((a, b) => {
        let aValue = a.getElementsByTagName('td')[columnIndex].textContent.trim();
        let bValue = b.getElementsByTagName('td')[columnIndex].textContent.trim();

        return sortDirectionsE[columnIndex] * aValue.localeCompare(bValue);
    });

    // Reordenar as linhas na tabela
    const noResultsRow = document.getElementById('noResultsRowEvento');
    rows.forEach(row => tableBody.appendChild(row));
    tableBody.insertBefore(noResultsRow, tableBody.firstChild);
}

// Filtro da tabela de participantes
document.addEventListener('DOMContentLoaded', function() {
    const searchNome = document.getElementById('searchNomeEvento');
    const searchEmail = document.getElementById('searchEmailEvento');
    const searchContato = document.getElementById('searchContatoEvento');
    const searchIdadeMin = document.getElementById('searchIdadeMinEvento');
    const searchIdadeMax = document.getElementById('searchIdadeMaxEvento');
    const searchSexo = document.getElementById('searchSexoEvento');
    const tableBody = document.getElementById('participantesEventoTableBody');

    if (tableBody) {
        const rows = tableBody.getElementsByTagName('tr');

        function filterTable() {
            const nomeValue = searchNome.value.toLowerCase();
            const emailValue = searchEmail.value.toLowerCase();
            const contatoValue = searchContato.value.toLowerCase();
            const idadeMinValue = searchIdadeMin.value ? parseInt(searchIdadeMin.value) : null;
            const idadeMaxValue = searchIdadeMax.value ? parseInt(searchIdadeMax.value) : null;
            const sexoValue = searchSexo.value;
            let visibleCount = 0;

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];

                // Pular a linha de "nenhum resultado"
                if (row.id === 'noResultsRowEvento') continue;

                const cells = row.getElementsByTagName('td');

                if (cells.length > 0) {
                    const nome = cells[0].textContent.toLowerCase();
                    const email = cells[1].textContent.toLowerCase();
                    const contato = cells[2].textContent.toLowerCase();
                    const idadeText = cells[3].textContent.trim();
                    const idade = idadeText ? parseInt(idadeText) : null;
                    const sexo = cells[4].textContent.trim();

                    const matchNome = nome.includes(nomeValue);
                    const matchEmail = email.includes(emailValue);
                    const matchContato = contato.includes(contatoValue);

                    // Filtro de idade (range)
                    let matchIdade = true;
                    if (idadeMinValue !== null && idade !== null) {
                        matchIdade = matchIdade && idade >= idadeMinValue;
                    }
                    if (idadeMaxValue !== null && idade !== null) {
                        matchIdade = matchIdade && idade <= idadeMaxValue;
                    }

                    // Filtro de sexo
                    const matchSexo = sexoValue === '' || sexo === sexoValue || (sexoValue === '' && sexo === '');

                    if (matchNome && matchEmail && matchContato && matchIdade && matchSexo) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }
            }

            // Mostrar/ocultar mensagem de "nenhum resultado"
            const noResultsRow = document.getElementById('noResultsRowEvento');
            if (visibleCount === 0) {
                noResultsRow.style.display = '';
            } else {
                noResultsRow.style.display = 'none';
            }
        }

        searchNome.addEventListener('keyup', filterTable);
        searchEmail.addEventListener('keyup', filterTable);
        searchContato.addEventListener('keyup', filterTable);
        searchIdadeMin.addEventListener('keyup', filterTable);
        searchIdadeMax.addEventListener('keyup', filterTable);
        searchSexo.addEventListener('change', filterTable);
    }
});

// Filtro da tabela de organizadores
document.addEventListener('DOMContentLoaded', function() {
    const searchNomeOrg = document.getElementById('searchNomeOrg');
    const searchCargoOrg = document.getElementById('searchCargoOrg');
    const searchEmailOrg = document.getElementById('searchEmailOrg');
    const searchContatoOrg = document.getElementById('searchContatoOrg');
    const orgTable = document.getElementById('organizadoresTable');

    if (orgTable && searchNomeOrg) {
        const tableBody = orgTable.getElementsByTagName('tbody')[0];
        const rows = tableBody.getElementsByTagName('tr');

        function filterOrgTable() {
            const nomeValue = searchNomeOrg.value.toLowerCase();
            const cargoValue = searchCargoOrg.value.toLowerCase();
            const emailValue = searchEmailOrg.value.toLowerCase();
            const contatoValue = searchContatoOrg.value.toLowerCase();
            let visibleCount = 0;

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');

                if (cells.length > 0) {
                    const nome = cells[0].textContent.toLowerCase();
                    const cargo = cells[1].textContent.toLowerCase();
                    const email = cells[2].textContent.toLowerCase();
                    const contato = cells[3].textContent.toLowerCase();

                    const matchNome = nome.includes(nomeValue);
                    const matchCargo = cargo.includes(cargoValue);
                    const matchEmail = email.includes(emailValue);
                    const matchContato = contato.includes(contatoValue);

                    if (matchNome && matchCargo && matchEmail && matchContato) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        }

        searchNomeOrg.addEventListener('keyup', filterOrgTable);
        searchCargoOrg.addEventListener('keyup', filterOrgTable);
        searchEmailOrg.addEventListener('keyup', filterOrgTable);
        searchContatoOrg.addEventListener('keyup', filterOrgTable);
    }
});
</script>
@endsection
