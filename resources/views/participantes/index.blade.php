@extends('layouts.app')

@section('titulo', 'Lista de Participantes')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
       <h1 class="text-5xl font-bold text-gray-800 mb-2 font-titulo">Lista de Participantes</h1>
        <a href="/participantes/novo" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-700 focus:shadow-outline focus:outline-none">
            <i class="fas fa-user-plus mr-2"></i>Novo Participante
        </a>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full">
                <div class="overflow-hidden border rounded-lg">
                    <table class="min-w-full divide-y divide-neutral-200" style="table-layout: fixed;">
                        <thead class="bg-neutral-50">
                            <tr class="text-neutral-500">
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase cursor-pointer hover:bg-neutral-100" style="width: 25%;" onclick="sortTableParticipantes(0)">
                                    Nome <i class="fas fa-sort ml-1" id="sortIconP0"></i>
                                </th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 30%;">Email</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 20%;">Contato</th>
                                <th class="px-5 py-3 text-xs font-medium text-right uppercase" style="width: 25%;">Ações</th>
                            </tr>
                            <tr class="bg-white">
                                <th class="px-3 py-1">
                                    <input type="text" id="searchNome" placeholder="Buscar nome..."
                                           class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                </th>
                                <th class="px-3 py-1">
                                    <input type="text" id="searchEmail" placeholder="Buscar email..."
                                           class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                </th>
                                <th class="px-3 py-1">
                                    <input type="text" id="searchContato" placeholder="Buscar contato..."
                                           class="w-full px-2 py-1 text-xs font-normal border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                                </th>
                                <th class="px-3 py-1"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200" id="participantesTableBody">
                            <tr id="noResultsRow" style="display: none;">
                                <td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm">
                                    Nenhum resultado encontrado
                                </td>
                            </tr>
                            @foreach ($participantes as $participante)
                            <tr class="text-neutral-800 hover:bg-neutral-50 data-row">
                                <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $participante->nome }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $participante->email ?: 'Não informado' }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">
                                    {{ $participante->telefone ?: 'Não informado' }}
                                    @if($participante->telefone && $participante->is_whatsapp)
                                        <i class="fab fa-whatsapp text-green-500 ml-1"></i>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="/participantes/{{ $participante->id }}"
                                       class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:shadow-outline focus:outline-none mr-2">
                                        Detalhes
                                    </a>
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
</div>

<script>
let sortDirectionsP = [0]; // 0 = não ordenado, 1 = crescente, -1 = decrescente

function sortTableParticipantes(columnIndex) {
    const tableBody = document.getElementById('participantesTableBody');
    const rows = Array.from(tableBody.getElementsByTagName('tr')).filter(row => row.classList.contains('data-row'));
    const sortIcon = document.getElementById('sortIconP' + columnIndex);

    // Atualizar direção da ordenação
    sortDirectionsP[columnIndex] = sortDirectionsP[columnIndex] === 1 ? -1 : 1;

    // Atualizar ícone
    sortIcon.className = sortDirectionsP[columnIndex] === 1 ? 'fas fa-sort-up ml-1' : 'fas fa-sort-down ml-1';

    rows.sort((a, b) => {
        let aValue = a.getElementsByTagName('td')[columnIndex].textContent.trim();
        let bValue = b.getElementsByTagName('td')[columnIndex].textContent.trim();

        return sortDirectionsP[columnIndex] * aValue.localeCompare(bValue);
    });

    // Reordenar as linhas na tabela
    const noResultsRow = document.getElementById('noResultsRow');
    rows.forEach(row => tableBody.appendChild(row));
    tableBody.insertBefore(noResultsRow, tableBody.firstChild);
}

document.addEventListener('DOMContentLoaded', function() {
    const searchNome = document.getElementById('searchNome');
    const searchEmail = document.getElementById('searchEmail');
    const searchContato = document.getElementById('searchContato');
    const tableBody = document.getElementById('participantesTableBody');
    const rows = tableBody.getElementsByTagName('tr');

    function filterTable() {
        const nomeValue = searchNome.value.toLowerCase();
        const emailValue = searchEmail.value.toLowerCase();
        const contatoValue = searchContato.value.toLowerCase();
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];

            // Pular a linha de "nenhum resultado"
            if (row.id === 'noResultsRow') continue;

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
        const noResultsRow = document.getElementById('noResultsRow');
        if (visibleCount === 0) {
            noResultsRow.style.display = '';
        } else {
            noResultsRow.style.display = 'none';
        }
    }

    searchNome.addEventListener('keyup', filterTable);
    searchEmail.addEventListener('keyup', filterTable);
    searchContato.addEventListener('keyup', filterTable);
});
</script>
@endsection