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
            'cor_principal' => 'required|string|max:7',
            'cor_destaque' => 'required|string|max:7',
            'logo' => 'nullable|image|max:2048',
            'imagem_fundo' => 'nullable|image|max:5120',
            'template_mensagem_compartilhar' => 'nullable|string|max:1000'
        ]);

        // Atualiza o evento
        $evento->update([
            'landing_page_ativa' => $request->boolean('landing_page_ativa')
        ]);

        // Garante que o slug existe
        if (!$evento->slug) {
            $evento->slug = SlugService::gerarSlugUnico($evento->nome, $evento->id);
            $evento->save();
        }

        // Busca ou cria o tema
        $tema = $evento->tema ?? new EventoTema(['evento_id' => $evento->id]);

        $tema->cor_principal = $request->input('cor_principal');
        $tema->cor_destaque = $request->input('cor_destaque');
        $tema->template_mensagem_compartilhar = $request->input('template_mensagem_compartilhar');

        // Upload de logo
        if ($request->hasFile('logo')) {
            if ($tema->logo) {
                Storage::disk('public')->delete($tema->logo);
            }
            $tema->logo = $request->file('logo')->store('eventos/logos', 'public');
        }

        // Upload de imagem de fundo
        if ($request->hasFile('imagem_fundo')) {
            if ($tema->imagem_fundo) {
                Storage::disk('public')->delete($tema->imagem_fundo);
            }
            $tema->imagem_fundo = $request->file('imagem_fundo')->store('eventos/fundos', 'public');
        }

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
