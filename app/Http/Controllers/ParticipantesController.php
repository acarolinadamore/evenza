<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participante;
use App\Models\Evento;

class ParticipantesController extends Controller
{
    public function index()
    {
        $participantes = Participante::all();
        return view('participantes.index', ['participantes' => $participantes]);
    }

    public function create(Request $request)
    {
        $eventos = Evento::all();
        $eventoId = $request->query('evento_id');
        $evento = $eventoId ? Evento::find($eventoId) : null;

        return view('participantes.create', [
            'eventos' => $eventos,
            'eventoId' => $eventoId,
            'evento' => $evento
        ]);
    }

    public function store(Request $request)
{
    $participante = new Participante();
    $participante->nome = $request->nome;
    $participante->email = $request->email ?? null;
    $participante->telefone = $request->telefone ?? null;
    $participante->is_whatsapp = $request->has('is_whatsapp') ? 1 : 0;
    $participante->evento_id = $request->evento_id ?? null;
    $participante->save();

    // Se veio de um evento específico, redireciona de volta para o evento
    if ($request->evento_id) {
        return redirect('/eventos/' . $request->evento_id)->with('sucesso', 'Participante cadastrado com sucesso!');
    }

    return redirect('/participantes')->with('sucesso', 'Participante cadastrado com sucesso!');
}

    public function show(string $id)
    {
        $participante = Participante::with('evento')->find($id);

        // Buscar todos os participantes com o mesmo email ou telefone (histórico)
        $historico = Participante::with('evento')
            ->where('id', '!=', $id)
            ->where(function($query) use ($participante) {
                if ($participante->email) {
                    $query->orWhere('email', $participante->email);
                }
                if ($participante->telefone) {
                    $query->orWhere('telefone', $participante->telefone);
                }
            })
            ->get();

        $totalEventos = $historico->count() + ($participante->evento ? 1 : 0);

        return view('participantes.show', [
            'participante' => $participante,
            'historico' => $historico,
            'totalEventos' => $totalEventos
        ]);
    }

    public function edit(string $id)
    {
        $participante = Participante::find($id);
        $eventos = Evento::all();
        return view('participantes.edit', ['participante' => $participante, 'eventos' => $eventos]);
    }

   public function update(Request $request)
{
    $participante = Participante::find($request->id);
    $participante->nome = $request->nome;
    $participante->email = $request->email ?? null;
    $participante->telefone = $request->telefone ?? null;
    $participante->is_whatsapp = $request->has('is_whatsapp') ? 1 : 0;
    $participante->evento_id = $request->evento_id ?? null;
    $participante->save();

    return redirect('/participantes')->with('sucesso', 'Participante atualizado com sucesso!');
}

    public function destroy(Request $request)
    {
        Participante::destroy($request->id);
        return redirect('/participantes')->with('sucesso', 'Participante excluído com sucesso!');
    }
}