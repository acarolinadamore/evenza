@extends('layouts.app')

@section('titulo', 'Participantes')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
       <h1 class="text-5xl font-bold text-gray-800 mb-2 font-titulo">Participantes</h1>
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
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase cursor-pointer hover:bg-neutral-100" style="width: 20%;" onclick="sortTableParticipantes(0)">
                                    Nome <i class="fas fa-sort ml-1 text-gray-300" id="sortIconP0"></i>
                                </th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 18%;">Email</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 15%;">Contato</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 12%;">Idade</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase" style="width: 10%;">Sexo</th>
                                <th class="px-5 py-3 text-xs font-medium text-center uppercase" style="width: 25%;">Ações</th>
                            </tr>
                            <tr class="bg-white">
                                <th class="px-2 py-3">
                                    <input type="text" id="searchNome" placeholder="Buscar nome..."
                                           class="w-full px-3 py-2 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                </th>
                                <th class="px-2 py-3">
                                    <input type="text" id="searchEmail" placeholder="Buscar email..."
                                           class="w-full px-3 py-2 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                </th>
                                <th class="px-2 py-3">
                                    <input type="text" id="searchContato" placeholder="Buscar contato..."
                                           class="w-full px-3 py-2 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                </th>
                                <th class="px-2 py-3">
                                    <div class="flex gap-1">
                                        <input type="number" id="searchIdadeMin" placeholder="Min" min="0" max="150"
                                               class="w-1/2 px-1 py-1 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                        <input type="number" id="searchIdadeMax" placeholder="Max" min="0" max="150"
                                               class="w-1/2 px-1 py-1 text-xs font-normal bg-gray-50 border-0 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </div>
                                </th>
                                <th class="px-2 py-3">
                                    <select id="searchSexo" style="
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
                                <th class="px-2 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200" id="participantesTableBody">
                            <tr id="noResultsRow" style="display: none;">
                                <td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">
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
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $participante->idade ?: '' }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">
                                    @if($participante->sexo == 'M')
                                        M
                                    @elseif($participante->sexo == 'F')
                                        F
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-sm font-medium text-center whitespace-nowrap">
                                    <a href="/participantes/{{ $participante->id }}"
                                       class="inline-flex items-center justify-center w-20 px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 focus:shadow-outline focus:outline-none mr-2">
                                        Ver
                                    </a>
                                    <a href="/participantes/editar/{{ $participante->id }}"
                                       class="inline-flex items-center justify-center w-20 px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-yellow-500 rounded-md hover:bg-yellow-600 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-600 focus:shadow-outline focus:outline-none mr-2">
                                        Editar
                                    </a>
                                    <form action="/participantes/excluir" method="post" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $participante->id }}">
                                        <button type="submit"
                                                class="inline-flex items-center justify-center w-20 px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 bg-red-600 rounded-md hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-700 focus:shadow-outline focus:outline-none"
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
    sortIcon.className = sortDirectionsP[columnIndex] === 1 ? 'fas fa-arrow-up ml-1 text-blue-600' : 'fas fa-arrow-down ml-1 text-blue-600';

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
    const searchIdadeMin = document.getElementById('searchIdadeMin');
    const searchIdadeMax = document.getElementById('searchIdadeMax');
    const searchSexo = document.getElementById('searchSexo');
    const tableBody = document.getElementById('participantesTableBody');
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
            if (row.id === 'noResultsRow') continue;

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
    searchIdadeMin.addEventListener('keyup', filterTable);
    searchIdadeMax.addEventListener('keyup', filterTable);
    searchSexo.addEventListener('change', filterTable);
});
</script>
@endsection