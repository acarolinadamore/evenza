<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Services\SlugService;

class EventosController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->role === 'administrador') {
            $eventos = Evento::orderBy('data_evento', 'desc')->get();
        } elseif ($user && $user->role === 'organizador') {
            // Get eventos assigned to this user, or all eventos if none assigned
            $eventos = $user->eventos()->orderBy('data_evento', 'desc')->get();
            if ($eventos->isEmpty()) {
                $eventos = Evento::orderBy('data_evento', 'desc')->get();
            }
        } else {
            $eventos = Evento::orderBy('data_evento', 'desc')->get();
        }

        return view('eventos.index', ['eventos' => $eventos]);
    }

    public function create()
    {
        return view('eventos.create');
    }

public function store(Request $request)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'slug' => 'nullable|string|unique:eventos,slug',
    ]);

    $evento = new Evento();
    $evento->nome = $request->nome;

    // Se o usuário forneceu um slug personalizado, use-o. Caso contrário, gere automaticamente.
    if ($request->slug) {
        $evento->slug = $request->slug;
    } else {
        $evento->slug = SlugService::gerarSlugUnico($request->nome);
    }

    $evento->descricao = $request->descricao ?? null;
    $evento->data_evento = $request->data_evento ?? null;
    $evento->hora_evento = $request->hora_evento ?? null;
    $evento->local = $request->local ?? null;
    $evento->endereco = $request->endereco ?? null;
    $evento->valor_ingresso = $request->valor_ingresso ?? null;
    $evento->custo_por_pessoa = $request->custo_por_pessoa ?? null;
    $evento->whatsapp_oficial = $request->whatsapp_oficial ?? null;
    $evento->observacoes = $request->observacoes ?? null;
    $evento->status = $request->status ?? 'rascunho';
    $evento->capacidade = $request->capacidade ?? null;
    $evento->save();

    return redirect('/eventos')->with('sucesso', 'Evento criado com sucesso!');
}

    public function edit(string $id)
    {
        $evento = Evento::find($id);
        return view('eventos.edit', ['evento' => $evento]);
    }

    public function update(Request $request)
{
    $evento = Evento::find($request->id);

    $request->validate([
        'nome' => 'required|string|max:255',
        'slug' => 'nullable|string|unique:eventos,slug,' . $evento->id,
    ]);

    $evento->nome = $request->nome;

    // Se o usuário forneceu um slug personalizado, use-o. Caso contrário, gere automaticamente se não existir.
    if ($request->slug) {
        $evento->slug = $request->slug;
    } elseif (!$evento->slug) {
        $evento->slug = SlugService::gerarSlugUnico($request->nome, $evento->id);
    }

    $evento->descricao = $request->descricao ?? null;
    $evento->data_evento = $request->data_evento ?? null;
    $evento->hora_evento = $request->hora_evento ?? null;
    $evento->local = $request->local ?? null;
    $evento->endereco = $request->endereco ?? null;
    $evento->valor_ingresso = $request->valor_ingresso ?? null;
    $evento->custo_por_pessoa = $request->custo_por_pessoa ?? null;
    $evento->whatsapp_oficial = $request->whatsapp_oficial ?? null;
    $evento->observacoes = $request->observacoes ?? null;
    $evento->status = $request->status ?? 'rascunho';
    $evento->capacidade = $request->capacidade ?? null;
    $evento->save();

    return redirect('/eventos')->with('sucesso', 'Evento atualizado com sucesso!');
}

    public function show(string $id)
    {
        $evento = Evento::with('participantes')->find($id);
        return view('eventos.show', [
            'evento' => $evento
        ]);
    }

    public function paginaPublica(string $slug)
    {
        $evento = Evento::where('slug', $slug)->firstOrFail();
        return view('eventos.publico', ['evento' => $evento]);
    }

    public function inscricaoPublica(Request $request, string $slug)
    {
        $evento = Evento::where('slug', $slug)->firstOrFail();

        // Verificar se o evento está esgotado
        if ($evento->capacidade && $evento->participantes()->count() >= $evento->capacidade) {
            return redirect('/evento/' . $slug)->with('erro', 'Desculpe, as vagas para este evento já foram preenchidas.');
        }

        $participante = new \App\Models\Participante();
        $participante->nome = $request->nome;
        $participante->email = $request->email ?? null;
        $participante->telefone = $request->telefone ?? null;
        $participante->is_whatsapp = $request->has('is_whatsapp') ? 1 : 0;
        $participante->evento_id = $evento->id;
        $participante->save();

        return redirect('/evento/' . $slug)->with('sucesso', 'Inscrição realizada com sucesso!');
    }

    public function destroy(Request $request)
    {
        Evento::destroy($request->id);
        return redirect('/eventos')->with('sucesso', 'Evento excluído com sucesso!');
    }

    /**
     * Verifica se um slug já existe
     */
    public function verificarSlug(Request $request)
    {
        $slug = $request->input('slug');
        $eventoId = $request->input('evento_id');

        $query = Evento::where('slug', $slug);

        if ($eventoId) {
            $query->where('id', '!=', $eventoId);
        }

        $existe = $query->exists();

        return response()->json(['existe' => $existe]);
    }
}