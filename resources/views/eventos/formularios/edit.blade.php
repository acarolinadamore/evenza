@extends('layouts.app')

@section('conteudo')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('eventos.formularios.index', $evento) }}"
               class="inline-flex items-center justify-center w-10 h-10 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 focus:outline-none"
               title="Voltar">
                <i class="fas fa-chevron-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Formulário</h1>
                <p class="text-gray-600 mt-1">{{ $evento->nome }}</p>
            </div>
        </div>


        <!-- Formulário -->
        <form action="{{ route('eventos.formularios.update', [$evento, $formulario]) }}" method="POST" id="formulario-form">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Configurações do Formulário -->
                <div class="lg:col-span-1">
                    <!-- Nome do Formulário -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Nome do Formulário</h2>
                        <div>
                            <input type="text" name="nome" required
                                   value="{{ old('nome', $formulario->nome) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Container Sticky para painéis laterais -->
                    <div class="sticky top-4 space-y-6">
                        <!-- Tipos de Campos -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">Tipos de Campos</h2>

                            <!-- Lista de Blocos Disponíveis -->
                            <div class="space-y-2" id="blocos-disponiveis">
                                <!-- Campos Genéricos -->
                                <button type="button" class="w-full text-left px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400 transition-colors bloco-disponivel" data-tipo="texto">
                                    <i class="fas fa-font text-gray-600 mr-2"></i>
                                    <span class="font-medium">Texto Curto</span>
                                </button>

                                <button type="button" class="w-full text-left px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400 transition-colors bloco-disponivel" data-tipo="textarea">
                                    <i class="fas fa-align-left text-gray-600 mr-2"></i>
                                    <span class="font-medium">Texto Longo</span>
                                </button>

                                <button type="button" class="w-full text-left px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400 transition-colors bloco-disponivel" data-tipo="select">
                                    <i class="fas fa-list text-gray-600 mr-2"></i>
                                    <span class="font-medium">Lista Suspensa</span>
                                </button>

                                <button type="button" class="w-full text-left px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400 transition-colors bloco-disponivel" data-tipo="radio">
                                    <i class="fas fa-dot-circle text-gray-600 mr-2"></i>
                                    <span class="font-medium">Múltipla Escolha</span>
                                </button>

                                <button type="button" class="w-full text-left px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400 transition-colors bloco-disponivel" data-tipo="checkbox">
                                    <i class="fas fa-check-square text-gray-600 mr-2"></i>
                                    <span class="font-medium">Caixas de Seleção</span>
                                </button>

                                <hr class="my-3 border-gray-300">

                                <!-- Campos Específicos -->
                                <button type="button" class="w-full text-left px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400 transition-colors bloco-disponivel" data-tipo="nome">
                                    <i class="fas fa-user text-blue-600 mr-2"></i>
                                    <span class="font-medium">Nome Completo</span>
                                </button>

                                <button type="button" class="w-full text-left px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400 transition-colors bloco-disponivel" data-tipo="email">
                                    <i class="fas fa-envelope text-green-600 mr-2"></i>
                                    <span class="font-medium">E-mail</span>
                                </button>

                                <button type="button" class="w-full text-left px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400 transition-colors bloco-disponivel" data-tipo="telefone">
                                    <i class="fas fa-phone text-purple-600 mr-2"></i>
                                    <span class="font-medium">Telefone</span>
                                </button>

                                <button type="button" class="w-full text-left px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-blue-400 transition-colors bloco-disponivel" data-tipo="mensagem">
                                    <i class="fas fa-info-circle text-orange-600 mr-2"></i>
                                    <span class="font-medium">Texto Informativo</span>
                                </button>
                            </div>
                        </div>

                        <!-- Após Enviar -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">Após Enviar</h2>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Mensagem de Sucesso
                                </label>
                                <textarea name="mensagem_sucesso" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('mensagem_sucesso', $formulario->mensagem_sucesso) }}</textarea>
                            </div>
                        </div>

                        <!-- Background do Container -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">Background do Container</h2>

                            <div class="space-y-4">
                                <!-- Cor de Fundo -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Cor de Fundo
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <input type="color"
                                               id="background_cor_picker"
                                               name="background_cor"
                                               value="{{ old('background_cor', $formulario->background_cor ?? '#ffffff') }}"
                                               class="h-10 w-20 border border-gray-300 rounded cursor-pointer">
                                        <input type="text"
                                               id="background_cor_text"
                                               value="{{ old('background_cor', $formulario->background_cor ?? '#ffffff') }}"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                                               readonly>
                                        @if($formulario->background_cor)
                                        <button type="button"
                                                onclick="limparCorFundo()"
                                                class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                                                title="Remover cor de fundo">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                    </div>
                                    <input type="hidden" name="remover_background_cor" id="remover_background_cor" value="0">
                                    <p class="text-xs text-gray-500 mt-1">Cor de fundo do container na landing page</p>
                                </div>

                                <!-- Imagem de Fundo -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Imagem de Fundo
                                    </label>
                                    <input type="file" name="background_imagem" accept="image/*"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="text-xs text-gray-500 mt-1">Imagem de fundo do container (opcional)</p>

                                    @if($formulario->background_imagem)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $formulario->background_imagem) }}"
                                                 alt="Background atual"
                                                 class="w-32 h-32 object-cover rounded border border-gray-200">
                                            <label class="flex items-center mt-2">
                                                <input type="checkbox" name="remover_background_imagem" value="1" class="mr-2">
                                                <span class="text-sm text-red-600">Remover imagem</span>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Formulário Ativo -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">Ativo</h2>
                            <div class="flex items-center">
                                <input type="checkbox" name="ativo" value="1" {{ old('ativo', $formulario->ativo) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label class="ml-2 text-sm font-medium text-gray-700">
                                    Ativo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview/Construtor do Formulário -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Campos do Formulário</h2>

                        <div id="campos-container" class="space-y-4 min-h-[400px]">
                            <!-- Placeholder quando vazio -->
                            <div id="campos-empty" class="text-center py-16 text-gray-400 hidden">
                                <i class="fas fa-clipboard-list text-6xl mb-4"></i>
                                <p class="text-lg">Clique nos campos ao lado para adicionar ao formulário</p>
                            </div>
                        </div>

                        <!-- Input hidden para enviar campos -->
                        <input type="hidden" name="campos_json" id="campos-json">
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('eventos.formularios.index', $evento) }}"
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                    <i class="fas fa-save mr-2"></i>Atualizar Formulário
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Template para campo do formulário -->
<template id="campo-template">
    <div class="campo-item bg-gray-50 border border-gray-300 rounded-lg p-4 relative" data-campo-id="">
        <div class="flex justify-between items-start mb-3">
            <div class="flex items-center gap-2 flex-1">
                <i class="fas fa-grip-vertical text-gray-400 cursor-move campo-handle"></i>
                <span class="campo-icon"></span>
                <span class="campo-tipo-label font-medium text-gray-700"></span>
            </div>
            <div class="flex gap-2">
                <button type="button" class="text-blue-600 hover:text-blue-800 btn-editar-campo">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="text-red-600 hover:text-red-800 btn-remover-campo">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <div class="campo-config pl-8">
            <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Label do Campo *
                </label>
                <input type="text" class="campo-label-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Ex: Qual é seu nome?">
            </div>

            <div class="mb-2 campo-placeholder-group">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Placeholder (opcional)
                </label>
                <input type="text" class="campo-placeholder-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Ex: Digite seu nome completo">
            </div>

            <div class="campo-opcoes-group hidden mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Opções (uma por linha) *
                </label>
                <textarea class="campo-opcoes-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" rows="3" placeholder="Opção 1&#10;Opção 2&#10;Opção 3"></textarea>
            </div>

            <div class="flex items-center campo-obrigatorio-group">
                <input type="checkbox" class="campo-obrigatorio-input w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                <label class="ml-2 text-sm font-medium text-gray-700">
                    Campo obrigatório
                </label>
            </div>
        </div>
    </div>
</template>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let camposData = [];
        let campoIdCounter = 0;

        const camposContainer = document.getElementById('campos-container');
        const camposEmpty = document.getElementById('campos-empty');
        const campoTemplate = document.getElementById('campo-template');
        const camposJson = document.getElementById('campos-json');

        // Configuração de ícones e labels por tipo
        const tipoConfig = {
            'texto': { icon: 'fas fa-font text-gray-600', label: 'Texto Curto', placeholder: true, opcoes: false },
            'textarea': { icon: 'fas fa-align-left text-gray-600', label: 'Texto Longo', placeholder: true, opcoes: false },
            'select': { icon: 'fas fa-list text-gray-600', label: 'Lista Suspensa', placeholder: false, opcoes: true },
            'radio': { icon: 'fas fa-dot-circle text-gray-600', label: 'Múltipla Escolha', placeholder: false, opcoes: true },
            'checkbox': { icon: 'fas fa-check-square text-gray-600', label: 'Caixas de Seleção', placeholder: false, opcoes: true },
            'nome': { icon: 'fas fa-user text-blue-600', label: 'Nome Completo', placeholder: true, opcoes: false },
            'email': { icon: 'fas fa-envelope text-green-600', label: 'E-mail', placeholder: true, opcoes: false },
            'telefone': { icon: 'fas fa-phone text-purple-600', label: 'Telefone', placeholder: true, opcoes: false },
            'mensagem': { icon: 'fas fa-info-circle text-orange-600', label: 'Texto Informativo', placeholder: false, opcoes: false }
        };

        // Carregar campos existentes
        const camposExistentes = @json($formulario->campos);

        camposExistentes.forEach(campo => {
            adicionarCampo(campo.tipo, {
                label: campo.label,
                placeholder: campo.placeholder || '',
                opcoes: campo.opcoes || [],
                obrigatorio: campo.obrigatorio
            });
        });

        // Adicionar campo ao clicar
        document.querySelectorAll('.bloco-disponivel').forEach(btn => {
            btn.addEventListener('click', function() {
                const tipo = this.dataset.tipo;
                adicionarCampo(tipo);
            });
        });

        function adicionarCampo(tipo, dadosIniciais = null) {
            const campoId = `campo-${campoIdCounter++}`;
            const config = tipoConfig[tipo];

            // Clone template
            const clone = campoTemplate.content.cloneNode(true);
            const campoItem = clone.querySelector('.campo-item');
            campoItem.dataset.campoId = campoId;
            campoItem.dataset.tipo = tipo;

            // Configurar ícone e label
            campoItem.querySelector('.campo-icon').innerHTML = `<i class="${config.icon}"></i>`;
            campoItem.querySelector('.campo-tipo-label').textContent = config.label;

            // Mostrar/ocultar campos conforme tipo
            if (!config.placeholder) {
                campoItem.querySelector('.campo-placeholder-group').remove();
            }

            if (config.opcoes) {
                campoItem.querySelector('.campo-opcoes-group').classList.remove('hidden');
            }

            // Tipo mensagem não tem obrigatório
            if (tipo === 'mensagem') {
                campoItem.querySelector('.campo-obrigatorio-group').remove();
            }

            // Preencher com dados iniciais (para edição)
            if (dadosIniciais) {
                campoItem.querySelector('.campo-label-input').value = dadosIniciais.label || '';

                const placeholderInput = campoItem.querySelector('.campo-placeholder-input');
                if (placeholderInput) {
                    placeholderInput.value = dadosIniciais.placeholder || '';
                }

                const opcoesInput = campoItem.querySelector('.campo-opcoes-input');
                if (opcoesInput && dadosIniciais.opcoes) {
                    opcoesInput.value = Array.isArray(dadosIniciais.opcoes)
                        ? dadosIniciais.opcoes.join('\n')
                        : dadosIniciais.opcoes;
                }

                const obrigatorioInput = campoItem.querySelector('.campo-obrigatorio-input');
                if (obrigatorioInput) {
                    obrigatorioInput.checked = dadosIniciais.obrigatorio || false;
                }
            }

            // Adicionar ao container
            camposContainer.appendChild(clone);
            camposEmpty.classList.add('hidden');

            // Adicionar aos dados
            const novoCampo = {
                id: campoId,
                tipo: tipo,
                label: dadosIniciais?.label || '',
                placeholder: dadosIniciais?.placeholder || '',
                opcoes: dadosIniciais?.opcoes || [],
                obrigatorio: dadosIniciais?.obrigatorio || false
            };

            camposData.push(novoCampo);
            atualizarCamposJson();
            setupCampoEvents(campoItem);
        }

        function setupCampoEvents(campoItem) {
            const campoId = campoItem.dataset.campoId;

            // Remover campo
            campoItem.querySelector('.btn-remover-campo').addEventListener('click', function() {
                if (confirm('Deseja remover este campo?')) {
                    campoItem.remove();
                    camposData = camposData.filter(c => c.id !== campoId);

                    if (camposData.length === 0) {
                        camposEmpty.classList.remove('hidden');
                    }

                    atualizarCamposJson();
                }
            });

            // Atualizar dados ao editar
            campoItem.querySelector('.campo-label-input').addEventListener('input', function() {
                atualizarCampoData(campoId, 'label', this.value);
            });

            const placeholderInput = campoItem.querySelector('.campo-placeholder-input');
            if (placeholderInput) {
                placeholderInput.addEventListener('input', function() {
                    atualizarCampoData(campoId, 'placeholder', this.value);
                });
            }

            const opcoesInput = campoItem.querySelector('.campo-opcoes-input');
            if (opcoesInput) {
                opcoesInput.addEventListener('input', function() {
                    const opcoes = this.value.split('\n').filter(o => o.trim());
                    atualizarCampoData(campoId, 'opcoes', opcoes);
                });
            }

            const obrigatorioInput = campoItem.querySelector('.campo-obrigatorio-input');
            if (obrigatorioInput) {
                obrigatorioInput.addEventListener('change', function() {
                    atualizarCampoData(campoId, 'obrigatorio', this.checked);
                });
            }
        }

        function atualizarCampoData(campoId, propriedade, valor) {
            const campo = camposData.find(c => c.id === campoId);
            if (campo) {
                campo[propriedade] = valor;
                atualizarCamposJson();
            }
        }

        function atualizarCamposJson() {
            // Converter para formato esperado pelo controller
            const campos = camposData.map(c => ({
                tipo: c.tipo,
                label: c.label,
                placeholder: c.placeholder || null,
                opcoes: c.opcoes.length > 0 ? c.opcoes : null,
                obrigatorio: c.obrigatorio
            }));

            camposJson.value = JSON.stringify(campos);
        }

        // Validação do formulário
        document.getElementById('formulario-form').addEventListener('submit', function(e) {
            if (camposData.length === 0) {
                e.preventDefault();
                alert('Adicione pelo menos um campo ao formulário!');
                return false;
            }

            // Verificar se todos os campos têm label
            const camposSemLabel = camposData.filter(c => !c.label || c.label.trim() === '');
            if (camposSemLabel.length > 0) {
                e.preventDefault();
                alert('Todos os campos precisam ter um label!');
                return false;
            }

            // Verificar se campos com opções têm opções preenchidas
            const camposSemOpcoes = camposData.filter(c =>
                ['select', 'radio', 'checkbox'].includes(c.tipo) && (!c.opcoes || c.opcoes.length === 0)
            );
            if (camposSemOpcoes.length > 0) {
                e.preventDefault();
                alert('Campos de seleção precisam ter opções preenchidas!');
                return false;
            }

            // Processar JSON antes de enviar
            const campos = camposData.map(c => ({
                tipo: c.tipo,
                label: c.label,
                placeholder: c.placeholder || null,
                opcoes: c.opcoes.length > 0 ? c.opcoes : null,
                obrigatorio: c.obrigatorio || false
            }));

            // Criar inputs individuais para cada campo
            campos.forEach((campo, index) => {
                Object.keys(campo).forEach(key => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `campos[${index}][${key}]`;

                    if (key === 'opcoes' && Array.isArray(campo[key])) {
                        campo[key].forEach((opcao, opIndex) => {
                            const opInput = document.createElement('input');
                            opInput.type = 'hidden';
                            opInput.name = `campos[${index}][${key}][${opIndex}]`;
                            opInput.value = opcao;
                            this.appendChild(opInput);
                        });
                    } else if (key === 'obrigatorio') {
                        input.value = campo[key] ? '1' : '0';
                        this.appendChild(input);
                    } else if (campo[key] !== null) {
                        input.value = campo[key];
                        this.appendChild(input);
                    }
                });
            });
        });

        // Sincronizar color picker com campo de texto
        const colorPicker = document.getElementById('background_cor_picker');
        const colorText = document.getElementById('background_cor_text');

        if (colorPicker && colorText) {
            colorPicker.addEventListener('input', function() {
                colorText.value = this.value;
            });
        }
    });

    // Função para limpar cor de fundo
    function limparCorFundo() {
        const colorPicker = document.getElementById('background_cor_picker');
        const colorText = document.getElementById('background_cor_text');
        const removerInput = document.getElementById('remover_background_cor');

        if (confirm('Deseja remover a cor de fundo?')) {
            colorPicker.value = '#ffffff';
            colorText.value = '#ffffff';
            removerInput.value = '1';

            // Ocultar botão X
            event.target.closest('button').style.display = 'none';
        }
    }
</script>
@endsection
