<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\EventoOrganizador;

class EventoOrganizadorController extends Controller
{
    public function index(Evento $evento)
    {
        $organizadores = $evento->organizadores;
        return view('eventos.organizadores.index', compact('evento', 'organizadores'));
    }

    public function store(Request $request, Evento $evento)
    {
        // Check if creating from existing user
        if ($request->has('from_user') && $request->user_id) {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'cargo' => 'nullable|string|max:255',
                'telefone' => 'nullable|string|max:20',
                'is_whatsapp' => 'nullable|boolean',
            ]);

            $user = \App\Models\User::findOrFail($request->user_id);

            $ultimaOrdem = $evento->organizadores()->max('ordem') ?? 0;

            $evento->organizadores()->create([
                'nome' => $user->name,
                'cargo' => $request->cargo,
                'email' => $user->email,
                'telefone' => $request->telefone,
                'is_whatsapp' => $request->has('is_whatsapp') ? true : false,
                'ordem' => $ultimaOrdem + 1,
            ]);

            return redirect()->route('eventos.organizadores.index', $evento)
                ->with('success', 'Organizador adicionado com sucesso!');
        }

        // Creating new organizador
        $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'is_whatsapp' => 'nullable|boolean',
        ]);

        $ultimaOrdem = $evento->organizadores()->max('ordem') ?? 0;

        $evento->organizadores()->create([
            'nome' => $request->nome,
            'cargo' => $request->cargo,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'is_whatsapp' => $request->has('is_whatsapp') ? true : false,
            'ordem' => $ultimaOrdem + 1,
        ]);

        return redirect()->route('eventos.organizadores.index', $evento)
            ->with('success', 'Organizador adicionado com sucesso!');
    }

    public function update(Request $request, Evento $evento, EventoOrganizador $organizador)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'is_whatsapp' => 'nullable|boolean',
        ]);

        $organizador->update([
            'nome' => $request->nome,
            'cargo' => $request->cargo,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'is_whatsapp' => $request->has('is_whatsapp') ? true : false,
        ]);

        return redirect()->route('eventos.organizadores.index', $evento)
            ->with('success', 'Organizador atualizado com sucesso!');
    }

    public function destroy(Evento $evento, EventoOrganizador $organizador)
    {
        $organizador->delete();

        return redirect()->route('eventos.organizadores.index', $evento)
            ->with('success', 'Organizador removido com sucesso!');
    }

    public function reorder(Request $request, Evento $evento)
    {
        $ordem = $request->input('ordem', []);

        foreach ($ordem as $index => $id) {
            EventoOrganizador::where('id', $id)
                ->where('evento_id', $evento->id)
                ->update(['ordem' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
