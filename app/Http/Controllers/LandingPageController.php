<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Exibe a landing page pública de um evento
     */
    public function show(string $slug)
    {
        $evento = Evento::where('slug', $slug)
            ->where('landing_page_ativa', true)
            ->with([
                'tema',
                'blocos' => function ($query) {
                    $query->where('ativo', true)->orderBy('ordem');
                },
                'formularios' => function ($query) {
                    $query->where('ativo', true)->orderBy('ordem')->with('campos');
                }
            ])
            ->firstOrFail();

        return view('eventos.publico', compact('evento'));
    }
}
