<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoBloco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventoBlocoController extends Controller
{
    /**
     * Lista os blocos de um evento
     */
    public function index(Evento $evento)
    {
        $blocos = $evento->blocos()->orderBy('ordem')->get();

        return view('eventos.blocos.index', compact('evento', 'blocos'));
    }

    /**
     * Exibe o formulário de criação de bloco
     */
    public function create(Evento $evento)
    {
        return view('eventos.blocos.create', compact('evento'));
    }

    /**
     * Armazena um novo bloco
     */
    public function store(Request $request, Evento $evento)
    {
        $request->validate([
            'tipo' => 'required|in:hero,descricao,banner,mapa',
            'ativo' => 'boolean',
            'conteudo' => 'nullable|array'
        ]);

        $ordem = $evento->blocos()->max('ordem') + 1;

        $bloco = EventoBloco::create([
            'evento_id' => $evento->id,
            'tipo' => $request->input('tipo'),
            'ordem' => $ordem,
            'ativo' => $request->boolean('ativo', true),
            'conteudo' => $this->processarConteudo($request)
        ]);

        return redirect()->route('eventos.blocos.index', $evento)
            ->with('success', 'Bloco criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição de bloco
     */
    public function edit(Evento $evento, EventoBloco $bloco)
    {
        return view('eventos.blocos.edit', compact('evento', 'bloco'));
    }

    /**
     * Atualiza um bloco existente
     */
    public function update(Request $request, Evento $evento, EventoBloco $bloco)
    {
        $request->validate([
            'tipo' => 'required|in:hero,descricao,banner,mapa',
            'ativo' => 'boolean',
            'conteudo' => 'nullable|array'
        ]);

        $bloco->update([
            'tipo' => $request->input('tipo'),
            'ativo' => $request->boolean('ativo'),
            'conteudo' => $this->processarConteudo($request, $bloco)
        ]);

        return back()->with('success', 'Bloco atualizado com sucesso!');
    }

    /**
     * Remove um bloco
     */
    public function destroy(Evento $evento, EventoBloco $bloco)
    {
        // Remove imagens associadas se houver
        if ($bloco->conteudo && isset($bloco->conteudo['imagens'])) {
            foreach ($bloco->conteudo['imagens'] as $imagem) {
                Storage::disk('public')->delete($imagem);
            }
        }

        $bloco->delete();

        return back()->with('success', 'Bloco removido com sucesso!');
    }

    /**
     * Reordena os blocos
     */
    public function reorder(Request $request, Evento $evento)
    {
        $request->validate([
            'blocos' => 'required|array',
            'blocos.*' => 'exists:evento_blocos,id'
        ]);

        foreach ($request->input('blocos') as $ordem => $blocoId) {
            EventoBloco::where('id', $blocoId)
                ->where('evento_id', $evento->id)
                ->update(['ordem' => $ordem]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Atualiza a ordem dos componentes internos do bloco hero
     */
    public function updateComponentsOrder(Request $request, Evento $evento, EventoBloco $bloco)
    {
        $request->validate([
            'ordem' => 'required|array',
            'ordem.*' => 'in:titulo,subtitulo,imagem,cards'
        ]);

        $conteudo = $bloco->conteudo ?? [];
        $conteudo['ordem_componentes'] = $request->input('ordem');

        $bloco->update(['conteudo' => $conteudo]);

        return response()->json(['success' => true]);
    }

    /**
     * Processa o conteúdo do bloco de acordo com o tipo
     */
    private function processarConteudo(Request $request, ?EventoBloco $bloco = null): ?array
    {
        $tipo = $request->input('tipo');
        $conteudo = $request->input('conteudo', []);

        // Upload de imagem/logo do hero
        if ($tipo === 'hero' && $request->hasFile('conteudo.imagem')) {
            // Remove imagem antiga se existir
            if ($bloco && isset($bloco->conteudo['imagem'])) {
                Storage::disk('public')->delete($bloco->conteudo['imagem']);
            }
            $conteudo['imagem'] = $request->file('conteudo.imagem')->store('eventos/hero', 'public');

            // Inicializa posição padrão se não existir
            if (!isset($conteudo['imagem_posicao'])) {
                $conteudo['imagem_posicao'] = ['x' => 50, 'y' => 50]; // Centro
            }
        } elseif ($tipo === 'hero' && $bloco && isset($bloco->conteudo['imagem'])) {
            // Preservar imagem e posição antigas se não houver nova
            $conteudo['imagem'] = $bloco->conteudo['imagem'];
            $conteudo['imagem_posicao'] = $bloco->conteudo['imagem_posicao'] ?? ['x' => 50, 'y' => 50];
        }

        // Upload de imagem de fundo do hero
        if ($tipo === 'hero' && $request->hasFile('conteudo.imagem_fundo')) {
            // Remove imagem antiga se existir
            if ($bloco && isset($bloco->conteudo['imagem_fundo'])) {
                Storage::disk('public')->delete($bloco->conteudo['imagem_fundo']);
            }
            $conteudo['imagem_fundo'] = $request->file('conteudo.imagem_fundo')->store('eventos/hero', 'public');
        } elseif ($tipo === 'hero' && $bloco && isset($bloco->conteudo['imagem_fundo'])) {
            // Preservar imagem antiga se não houver nova
            $conteudo['imagem_fundo'] = $bloco->conteudo['imagem_fundo'];
        }

        // Upload de imagens do banner
        if ($tipo === 'banner') {
            if ($request->hasFile('conteudo.imagens')) {
                $imagens = [];
                foreach ($request->file('conteudo.imagens') as $imagem) {
                    $imagens[] = $imagem->store('eventos/blocos', 'public');
                }
                $conteudo['imagens'] = $imagens;
            } elseif ($bloco && isset($bloco->conteudo['imagens'])) {
                // Preservar imagens antigas se não houver novas
                $conteudo['imagens'] = $bloco->conteudo['imagens'];
            }
        }

        return empty($conteudo) ? null : $conteudo;
    }
}
