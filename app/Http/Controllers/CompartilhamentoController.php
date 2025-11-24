<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Participante;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class CompartilhamentoController extends Controller
{
    /**
     * Compartilha o evento via WhatsApp
     */
    public function evento(Evento $evento)
    {
        $link = WhatsAppService::gerarLinkEvento($evento);

        return redirect($link);
    }

    /**
     * Compartilha o evento com um participante específico
     */
    public function participante(Evento $evento, Participante $participante)
    {
        // Se o participante tiver WhatsApp, abre direto para o número
        if ($participante->is_whatsapp && $participante->contato) {
            $link = WhatsAppService::gerarLinkParticipante($participante, $evento);
            return redirect($link);
        }

        // Caso contrário, compartilha normalmente
        $link = WhatsAppService::gerarLinkEvento($evento);
        return redirect($link);
    }

    /**
     * Gera o link de compartilhamento (AJAX)
     */
    public function gerarLink(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'participante_id' => 'nullable|exists:participantes,id'
        ]);

        $evento = Evento::findOrFail($request->input('evento_id'));

        if ($request->has('participante_id')) {
            $participante = Participante::findOrFail($request->input('participante_id'));
            $link = WhatsAppService::gerarLinkParticipante($participante, $evento);
        } else {
            $link = WhatsAppService::gerarLinkEvento($evento);
        }

        return response()->json([
            'link' => $link,
            'url' => url("/{$evento->slug}")
        ]);
    }
}
