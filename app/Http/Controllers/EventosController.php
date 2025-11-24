<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class EventosController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();
        $locais = Evento::whereNotNull('local')->distinct()->pluck('local');
        return view('eventos.index', ['eventos' => $eventos, 'locais' => $locais]);
    }

    public function create()
    {
        return view('eventos.create');
    }

public function store(Request $request)
{
    $evento = new Evento();
    $evento->nome = $request->nome;
    $evento->slug = \Str::slug($request->nome) . '-' . uniqid();
    $evento->descricao = $request->descricao ?? null;
    $evento->data_evento = $request->data_evento ?? null;
    $evento->local = $request->local ?? null;
    $evento->valor_ingresso = $request->valor_ingresso ?? null;
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
    $evento->nome = $request->nome;
    if (!$evento->slug) {
        $evento->slug = \Str::slug($request->nome) . '-' . uniqid();
    }
    $evento->descricao = $request->descricao ?? null;
    $evento->data_evento = $request->data_evento ?? null;
    $evento->local = $request->local ?? null;
    $evento->valor_ingresso = $request->valor_ingresso ?? null;
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
}