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
            'tipo' => 'required|in:hero,descricao,agenda,banner,mapa,galeria',
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
            'tipo' => 'required|in:hero,descricao,agenda,banner,mapa,galeria',
            'ativo' => 'boolean',
            'conteudo' => 'nullable|array'
        ]);

        $bloco->update([
            'tipo' => $request->input('tipo'),
            'ativo' => $request->boolean('ativo'),
            'conteudo' => $this->processarConteudo($request)
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
     * Processa o conteúdo do bloco de acordo com o tipo
     */
    private function processarConteudo(Request $request): ?array
    {
        $tipo = $request->input('tipo');
        $conteudo = $request->input('conteudo', []);

        // Upload de imagens se necessário
        if (in_array($tipo, ['hero', 'banner', 'galeria'])) {
            if ($request->hasFile('conteudo.imagens')) {
                $imagens = [];
                foreach ($request->file('conteudo.imagens') as $imagem) {
                    $imagens[] = $imagem->store('eventos/blocos', 'public');
                }
                $conteudo['imagens'] = $imagens;
            }
        }

        return empty($conteudo) ? null : $conteudo;
    }
}
