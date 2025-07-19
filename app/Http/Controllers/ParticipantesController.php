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

    public function create()
    {
        $eventos = Evento::all();
        return view('participantes.create', ['eventos' => $eventos]);
    }

    public function store(Request $request)
{
    $participante = new Participante();
    $participante->nome = $request->nome;
    $participante->email = $request->email ?? null;       
    $participante->telefone = $request->telefone ?? null; 
    $participante->evento_id = $request->evento_id ?? null; 
    $participante->save();

    return redirect('/participantes');
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
    $participante->evento_id = $request->evento_id ?? null;
    $participante->save();

    return redirect('/participantes');
}

    public function destroy(Request $request)
    {
        Participante::destroy($request->id);
        return redirect('/participantes');
    }
}