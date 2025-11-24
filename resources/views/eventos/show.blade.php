@extends('layouts.app')

@section('titulo', 'Detalhes do Evento')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-5xl font-bold text-gray-800 font-titulo">{{ $evento->nome }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('eventos.landing-page.edit', $evento) }}"
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-purple-600 rounded-md hover:bg-purple-700 focus:ring-2 focus:ring-offset-2 focus:ring-purple-600 focus:shadow-outline focus:outline-none">
                    <i class="fas fa-palette mr-2"></i>Landing Page
                </a>
                <a href="/eventos/editar/{{ $evento->id }}"
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-yellow-500 rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600 focus:shadow-outline focus:outline-none">
                    <i class="fas fa-edit mr-2"></i>Editar Evento
                </a>
                <a href="/eventos"
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-500 hover:bg-neutral-600 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-600 focus:shadow-outline focus:outline-none">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
            </div>
        </div>

        <!-- Cards de Resumo -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="text-sm text-gray-600 mb-1">Data do Evento</div>
                <div class="text-2xl font-bold text-gray-800">
                    {{ $evento->data_evento ? date('d/m/Y', strtotime($evento->data_evento)) : 'Não definida' }}
                </div>
                @if($evento->data_evento)
                    @php
                        $dataEvento = \Carbon\Carbon::parse($evento->data_evento)->startOfDay();
                        $hoje = \Carbon\Carbon::now()->startOfDay();
                        $diasRestantes = (int) $hoje->diffInDays($dataEvento, false);
                    @endphp
                    <div class="text-xs mt-2">
                        @if($diasRestantes > 0)
                            <span class="text-orange-600 font-semibold">Faltam {{ $diasRestantes }} dia{{ $diasRestantes > 1 ? 's' : '' }}</span>
                        @elseif($diasRestantes == 0)
                            <span class="text-green-600 font-semibold">Evento é hoje!</span>
                        @else
                            <span class="text-gray-500">Evento realizado há {{ abs($diasRestantes) }} dia{{ abs($diasRestantes) > 1 ? 's' : '' }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="text-sm text-gray-600 mb-1">Participantes</div>
                <div class="text-2xl font-bold text-gray-800">
                    @if($evento->capacidade)
                        {{ $evento->participantes->count() }}/{{ $evento->capacidade }}
                    @else
                        {{ $evento->participantes->count() }}
                    @endif
                </div>
                @if($evento->capacidade)
                    @php
                        $inscritos = $evento->participantes->count();
                        $percentual = ($inscritos / $evento->capacidade) * 100;
                        $vagasRestantes = $evento->capacidade - $inscritos;
                    @endphp
                    <div class="text-xs mt-2">
                        @if($percentual >= 100)
                            <span class="text-red-600 font-semibold">Esgotado</span>
                        @elseif($percentual >= 80)
                            <span class="text-yellow-600 font-semibold">{{ $vagasRestantes }} vaga{{ $vagasRestantes != 1 ? 's' : '' }} restante{{ $vagasRestantes != 1 ? 's' : '' }}</span>
                        @else
                            <span class="text-green-600 font-semibold">{{ $vagasRestantes }} vaga{{ $vagasRestantes != 1 ? 's' : '' }} disponível{{ $vagasRestantes != 1 ? 'eis' : '' }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                <div class="text-sm text-gray-600 mb-1">Valor do Ingresso</div>
                <div class="text-2xl font-bold text-gray-800">
                    {{ $evento->valor_ingresso ? 'R$ ' . number_format($evento->valor_ingresso, 2, ',', '.') : 'Gratuito' }}
                </div>
            </div>

        </div>

        <!-- Informações do Evento -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Informações</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="text-sm text-gray-600">Local:</span>
                    <p class="text-gray-800">{{ $evento->local ?: 'Não informado' }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Descrição:</span>
                    <p class="text-gray-800">{{ $evento->descricao ?: 'Sem descrição' }}</p>
                </div>
            </div>

            @if($evento->slug)
            <div class="mt-4 pt-4 border-t">
                <span class="text-sm text-gray-600">Link Público de Inscrição:</span>
                <div class="flex gap-2 mt-2">
                    <input type="text"
                           value="{{ url('/evento/' . $evento->slug) }}"
                           readonly
                           class="flex-1 px-3 py-2 text-sm bg-gray-50 border rounded-md border-neutral-300"
                           id="linkPublico">
                    <button onclick="copiarLink()"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:shadow-outline focus:outline-none">
                        <i class="fas fa-copy mr-2"></i>Copiar Link
                    </button>
                    <a href="/evento/{{ $evento->slug }}"
                       target="_blank"
                       class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-700 focus:shadow-outline focus:outline-none">
                        <i class="fas fa-external-link-alt mr-2"></i>Visualizar
                    </a>
                </div>
            </div>
            @endif
        </div>
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
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase cursor-pointer hover:bg-neutral-100" style="width: 25%;" onclick="sortTableEvento(0)">
                                        Nome <i class="fas fa-sort ml-1" id="sortIconE0"></i>
                                    </th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 25%;">Email</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 20%;">Contato</th>
                                    <th class="px-5 py-3 text-xs font-medium text-right uppercase" style="width: 30%;">Ações</th>
                                </tr>
                                <tr class="bg-white">
                                    <th class="px-3 py-1">
                                        <input type="text" id="searchNomeEvento" placeholder="Buscar nome..."
                                               class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    </th>
                                    <th class="px-3 py-1">
                                        <input type="text" id="searchEmailEvento" placeholder="Buscar email..."
                                               class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    </th>
                                    <th class="px-3 py-1">
                                        <input type="text" id="searchContatoEvento" placeholder="Buscar contato..."
                                               class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    </th>
                                    <th class="px-3 py-1"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200" id="participantesEventoTableBody">
                                <tr id="noResultsRowEvento" style="display: none;">
                                    <td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm">
                                        Nenhum resultado encontrado
                                    </td>
                                </tr>
                                @foreach ($evento->participantes as $participante)
                                <tr class="text-neutral-800 hover:bg-neutral-50 data-row">
                                    <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $participante->nome }}</td>
                                    <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $participante->email ?: 'Não informado' }}</td>
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
                                        @else
                                            Não informado
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
</div>

<script>
function copiarLink() {
    const input = document.getElementById('linkPublico');
    input.select();
    input.setSelectionRange(0, 99999);
    document.execCommand('copy');

    alert('Link copiado para a área de transferência!');
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
    const tableBody = document.getElementById('participantesEventoTableBody');

    if (tableBody) {
        const rows = tableBody.getElementsByTagName('tr');

        function filterTable() {
            const nomeValue = searchNome.value.toLowerCase();
            const emailValue = searchEmail.value.toLowerCase();
            const contatoValue = searchContato.value.toLowerCase();
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

                    const matchNome = nome.includes(nomeValue);
                    const matchEmail = email.includes(emailValue);
                    const matchContato = contato.includes(contatoValue);

                    if (matchNome && matchEmail && matchContato) {
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
    }
});
</script>
@endsection
