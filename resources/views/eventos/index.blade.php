@extends('layouts.app')

@section('titulo', 'Lista de Eventos')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-5xl font-bold text-gray-800 mb-2 font-titulo">Lista de Eventos</h1>
        <a href="/eventos/novo" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-950 hover:bg-neutral-900 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 focus:shadow-outline focus:outline-none">
            <i class="fas fa-plus mr-2"></i>Novo Evento
        </a>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full">
                <div class="overflow-hidden border rounded-lg">
                    <table class="min-w-full divide-y divide-neutral-200" style="table-layout: fixed;">
                        <thead class="bg-neutral-50">
                            <tr class="text-neutral-500">
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase cursor-pointer hover:bg-neutral-100" style="width: 20%;" onclick="sortTable(0)">
                                    Nome <i class="fas fa-sort ml-1" id="sortIcon0"></i>
                                </th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase cursor-pointer hover:bg-neutral-100" style="width: 15%;" onclick="sortTable(1)">
                                    Data do Evento <i class="fas fa-sort ml-1" id="sortIcon1"></i>
                                </th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 15%;">Local</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 12%;">Status</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 13%;">Participantes</th>
                                <th class="px-5 py-3 text-xs font-medium text-right uppercase" style="width: 25%;">Ações</th>
                            </tr>
                            <tr class="bg-white">
                                <th class="px-3 py-1">
                                    <input type="text" id="searchNome" placeholder="Buscar nome..."
                                           class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                </th>
                                <th class="px-3 py-1">
                                    <input type="text" id="searchData" placeholder="dd/mm/aaaa" maxlength="10"
                                           class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                </th>
                                <th class="px-3 py-1">
                                    <select id="searchLocal" class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        <option value="">Todos os locais</option>
                                        @foreach($locais as $local)
                                            <option value="{{ $local }}">{{ $local }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th class="px-3 py-1">
                                    <select id="searchStatus" class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        <option value="">Todos</option>
                                        <option value="rascunho">Rascunho</option>
                                        <option value="em_andamento">Em Andamento</option>
                                        <option value="concluido">Concluído</option>
                                    </select>
                                </th>
                                <th class="px-3 py-1">
                                    <input type="text" id="searchParticipantes" placeholder="Buscar..."
                                           class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                </th>
                                <th class="px-3 py-1"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200" id="eventosTableBody">
                            <tr id="noResultsRow" style="display: none;">
                                <td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">
                                    Nenhum resultado encontrado
                                </td>
                            </tr>
                            @foreach ($eventos as $evento)
                            <tr class="text-neutral-800 hover:bg-neutral-50 data-row" data-status="{{ $evento->status }}">
                                <td class="px-5 py-4 text-sm font-medium whitespace-nowrap align-middle">{{ $evento->nome }}</td>
                                <td class="px-5 py-4 text-sm align-middle">
                                    <div>{{ date('d/m/Y', strtotime($evento->data_evento)) }}</div>
                                    @php
                                        $dataEvento = \Carbon\Carbon::parse($evento->data_evento)->startOfDay();
                                        $hoje = \Carbon\Carbon::now()->startOfDay();
                                        $diasRestantes = (int) $hoje->diffInDays($dataEvento, false);
                                    @endphp
                                    @if($diasRestantes > 0)
                                        @if($diasRestantes <= 7)
                                            <div class="mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Faltam {{ $diasRestantes }} dia{{ $diasRestantes > 1 ? 's' : '' }}
                                                </span>
                                            </div>
                                        @elseif($diasRestantes <= 30)
                                            <div class="mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Faltam {{ $diasRestantes }} dia{{ $diasRestantes > 1 ? 's' : '' }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Faltam {{ $diasRestantes }} dia{{ $diasRestantes > 1 ? 's' : '' }}
                                                </span>
                                            </div>
                                        @endif
                                    @elseif($diasRestantes == 0)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Hoje
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap align-middle">{{ $evento->local }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap align-middle">
                                    @if($evento->status == 'rascunho')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Rascunho
                                        </span>
                                    @elseif($evento->status == 'em_andamento')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Em Andamento
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Concluído
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">
                                    @php
                                        $inscritos = $evento->participantes->count();
                                        $capacidade = $evento->capacidade;
                                    @endphp

                                    @if($capacidade)
                                        @php
                                            $percentual = ($inscritos / $capacidade) * 100;
                                        @endphp

                                        @if($percentual >= 100)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Esgotado ({{ $inscritos }}/{{ $capacidade }})
                                            </span>
                                        @elseif($percentual >= 80)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                {{ $inscritos }}/{{ $capacidade }} vagas
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $inscritos }}/{{ $capacidade }} vagas
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-600">{{ $inscritos }} inscritos</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="/eventos/{{ $evento->id }}"
                                       class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:shadow-outline focus:outline-none mr-2">
                                        Ver Evento
                                    </a>
                                    <a href="/eventos/editar/{{ $evento->id }}"
                                       class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-yellow-500 rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600 focus:shadow-outline focus:outline-none mr-2">
                                        Editar
                                    </a>
                                    <form action="/eventos/excluir" method="post" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $evento->id }}">
                                        <button type="submit"
                                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-red-600 rounded-md hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:shadow-outline focus:outline-none"
                                                onclick="return confirm('Deseja excluir este evento?')">
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
</div>

<script>
let sortDirections = [0, 0]; // 0 = não ordenado, 1 = crescente, -1 = decrescente

function sortTable(columnIndex) {
    const tableBody = document.getElementById('eventosTableBody');
    const rows = Array.from(tableBody.getElementsByTagName('tr')).filter(row => row.classList.contains('data-row'));
    const sortIcon = document.getElementById('sortIcon' + columnIndex);

    // Atualizar direção da ordenação
    sortDirections[columnIndex] = sortDirections[columnIndex] === 1 ? -1 : 1;

    // Atualizar todos os ícones
    for (let i = 0; i < 2; i++) {
        const icon = document.getElementById('sortIcon' + i);
        if (i === columnIndex) {
            icon.className = sortDirections[i] === 1 ? 'fas fa-sort-up ml-1' : 'fas fa-sort-down ml-1';
        } else {
            icon.className = 'fas fa-sort ml-1';
            sortDirections[i] = 0;
        }
    }

    rows.sort((a, b) => {
        let aValue = a.getElementsByTagName('td')[columnIndex].textContent.trim();
        let bValue = b.getElementsByTagName('td')[columnIndex].textContent.trim();

        // Para data, converter para formato comparável
        if (columnIndex === 1) {
            const aDate = aValue.split('/').reverse().join('');
            const bDate = bValue.split('/').reverse().join('');
            return sortDirections[columnIndex] * aDate.localeCompare(bDate);
        }

        return sortDirections[columnIndex] * aValue.localeCompare(bValue);
    });

    // Reordenar as linhas na tabela
    const noResultsRow = document.getElementById('noResultsRow');
    rows.forEach(row => tableBody.appendChild(row));
    tableBody.insertBefore(noResultsRow, tableBody.firstChild);
}

document.addEventListener('DOMContentLoaded', function() {
    const searchNome = document.getElementById('searchNome');
    const searchData = document.getElementById('searchData');
    const searchLocal = document.getElementById('searchLocal');
    const searchStatus = document.getElementById('searchStatus');
    const searchParticipantes = document.getElementById('searchParticipantes');
    const tableBody = document.getElementById('eventosTableBody');
    const rows = tableBody.getElementsByTagName('tr');

    // Máscara de data
    searchData.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        if (value.length >= 5) {
            value = value.substring(0, 5) + '/' + value.substring(5, 9);
        }
        e.target.value = value;
    });

    function filterTable() {
        const nomeValue = searchNome.value.toLowerCase();
        const dataValue = searchData.value.toLowerCase();
        const localValue = searchLocal.value.toLowerCase();
        const statusValue = searchStatus.value.toLowerCase();
        const participantesValue = searchParticipantes.value.toLowerCase();
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];

            // Pular a linha de "nenhum resultado"
            if (row.id === 'noResultsRow') continue;

            const cells = row.getElementsByTagName('td');

            if (cells.length > 0) {
                const nome = cells[0].textContent.toLowerCase();
                const data = cells[1].textContent.toLowerCase();
                const local = cells[2].textContent.toLowerCase();
                const status = row.getAttribute('data-status').toLowerCase();
                const participantes = cells[4].textContent.toLowerCase();

                const matchNome = nome.includes(nomeValue);
                const matchData = data.includes(dataValue);
                const matchLocal = localValue === '' || local.includes(localValue);
                const matchStatus = statusValue === '' || status === statusValue;
                const matchParticipantes = participantes.includes(participantesValue);

                if (matchNome && matchData && matchLocal && matchStatus && matchParticipantes) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            }
        }

        // Mostrar/ocultar mensagem de "nenhum resultado"
        const noResultsRow = document.getElementById('noResultsRow');
        if (visibleCount === 0) {
            noResultsRow.style.display = '';
        } else {
            noResultsRow.style.display = 'none';
        }
    }

    searchNome.addEventListener('keyup', filterTable);
    searchData.addEventListener('keyup', filterTable);
    searchLocal.addEventListener('change', filterTable);
    searchStatus.addEventListener('change', filterTable);
    searchParticipantes.addEventListener('keyup', filterTable);
});
</script>
@endsection