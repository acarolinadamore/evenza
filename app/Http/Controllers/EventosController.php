<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class EventosController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();
        return view('eventos.index', ['eventos' => $eventos]);
    }

    public function create()
    {
        return view('eventos.create');
    }

public function store(Request $request)
{
    $evento = new Evento();
    $evento->nome = $request->nome;
    $evento->descricao = $request->descricao ?? null;  
    $evento->data_evento = $request->data_evento ?? null;  
    $evento->local = $request->local ?? null;  
    $evento->save();

    return redirect('/eventos');
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
    $evento->descricao = $request->descricao ?? null;
    $evento->data_evento = $request->data_evento ?? null;
    $evento->local = $request->local ?? null;
    $evento->save();

    return redirect('/eventos');
}

    public function destroy(Request $request)
    {
        Evento::destroy($request->id);
        return redirect('/eventos');
    }
}