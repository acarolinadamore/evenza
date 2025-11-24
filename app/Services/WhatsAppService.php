<?php

namespace App\Services;

use App\Models\Evento;
use App\Models\Participante;

class WhatsAppService
{
    /**
     * Gera a URL de compartilhamento do WhatsApp para um evento
     */
    public static function gerarLinkEvento(Evento $evento, ?string $mensagemPersonalizada = null): string
    {
        $url = url("/{$evento->slug}");

        $mensagem = $mensagemPersonalizada ?? self::gerarMensagemPadrao($evento);

        return self::construirUrl($mensagem, $url);
    }

    /**
     * Gera a URL de compartilhamento do WhatsApp para um participante específico
     */
    public static function gerarLinkParticipante(Participante $participante, Evento $evento): string
    {
        $url = url("/{$evento->slug}");

        // Usa o template personalizado do tema se existir
        if ($evento->tema && $evento->tema->template_mensagem_compartilhar) {
            $mensagem = self::processarTemplate(
                $evento->tema->template_mensagem_compartilhar,
                $participante,
                $evento
            );
        } else {
            $mensagem = self::gerarMensagemParticipante($participante, $evento);
        }

        return self::construirUrl($mensagem, $url);
    }

    /**
     * Gera mensagem padrão para compartilhamento do evento
     */
    private static function gerarMensagemPadrao(Evento $evento): string
    {
        $mensagem = "Confira o evento *{$evento->nome}*!";

        if ($evento->data_evento) {
            $mensagem .= "\n📅 " . date('d/m/Y', strtotime($evento->data_evento));
        }

        if ($evento->local) {
            $mensagem .= "\n📍 {$evento->local}";
        }

        $mensagem .= "\n\nAcesse para mais informações:";

        return $mensagem;
    }

    /**
     * Gera mensagem padrão para compartilhamento com participante
     */
    private static function gerarMensagemParticipante(Participante $participante, Evento $evento): string
    {
        $mensagem = "Olá *{$participante->nome}*!";
        $mensagem .= "\n\nVocê está inscrito no evento *{$evento->nome}*";

        if ($evento->data_evento) {
            $mensagem .= "\n📅 " . date('d/m/Y H:i', strtotime($evento->data_evento));
        }

        if ($evento->local) {
            $mensagem .= "\n📍 {$evento->local}";
        }

        $mensagem .= "\n\nAcesse para mais informações:";

        return $mensagem;
    }

    /**
     * Processa template com variáveis do participante e evento
     */
    private static function processarTemplate(string $template, Participante $participante, Evento $evento): string
    {
        $variaveis = [
            '{nome}' => $participante->nome,
            '{email}' => $participante->email,
            '{contato}' => $participante->contato,
            '{evento_nome}' => $evento->nome,
            '{evento_data}' => $evento->data_evento ? date('d/m/Y H:i', strtotime($evento->data_evento)) : '',
            '{evento_local}' => $evento->local ?? '',
        ];

        return str_replace(array_keys($variaveis), array_values($variaveis), $template);
    }

    /**
     * Constrói a URL final do WhatsApp Web
     */
    private static function construirUrl(string $mensagem, string $url): string
    {
        $mensagemCompleta = $mensagem . "\n" . $url;
        $mensagemEncoded = urlencode($mensagemCompleta);

        return "https://web.whatsapp.com/send?text={$mensagemEncoded}";
    }

    /**
     * Gera link direto para enviar mensagem a um número específico
     */
    public static function gerarLinkDireto(string $numero, string $mensagem): string
    {
        // Remove caracteres não numéricos
        $numeroLimpo = preg_replace('/[^0-9]/', '', $numero);

        // Adiciona código do Brasil se necessário
        if (strlen($numeroLimpo) <= 11) {
            $numeroLimpo = '55' . $numeroLimpo;
        }

        $mensagemEncoded = urlencode($mensagem);

        return "https://web.whatsapp.com/send?phone={$numeroLimpo}&text={$mensagemEncoded}";
    }
}
