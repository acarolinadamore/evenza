<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoTema;
use App\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventoLandingPageController extends Controller
{
    /**
     * Exibe o formulário de configuração da landing page
     */
    public function edit(Evento $evento)
    {
        $evento->load('tema');

        // Cria tema padrão se não existir
        if (!$evento->tema) {
            $evento->tema = EventoTema::create([
                'evento_id' => $evento->id,
                'cor_principal' => '#1a1a1a',
                'cor_destaque' => '#ad8741'
            ]);
        }

        return view('eventos.landing-page.edit', compact('evento'));
    }

    /**
     * Atualiza as configurações da landing page
     */
    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'landing_page_ativa' => 'boolean',
            'slug' => 'required|string|max:255|regex:/^[a-z0-9-]+$/|unique:eventos,slug,' . $evento->id,
            'cor_principal' => 'required|string|max:7',
            'cor_destaque' => 'required|string|max:7'
        ]);

        // Atualiza o evento
        $evento->update([
            'landing_page_ativa' => $request->boolean('landing_page_ativa'),
            'slug' => $request->input('slug')
        ]);

        // Busca ou cria o tema
        $tema = $evento->tema ?? new EventoTema(['evento_id' => $evento->id]);

        $tema->cor_principal = $request->input('cor_principal');
        $tema->cor_destaque = $request->input('cor_destaque');
        $tema->save();

        return back()->with('success', 'Configurações da landing page atualizadas com sucesso!');
    }

    /**
     * Visualiza a landing page (preview)
     */
    public function preview(Evento $evento)
    {
        $evento->load([
            'tema',
            'blocos' => function ($query) {
                $query->where('ativo', true)->orderBy('ordem');
            },
            'formularios' => function ($query) {
                $query->where('ativo', true)->orderBy('ordem')->with('campos');
            }
        ]);

        return view('eventos.publico', compact('evento'));
    }
}
