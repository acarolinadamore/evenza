<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoFormulario;
use App\Models\FormularioResposta;
use Illuminate\Http\Request;

class FormularioRespostaController extends Controller
{
    /**
     * Lista as respostas de um formulário
     */
    public function index(Evento $evento, EventoFormulario $formulario)
    {
        $respostas = $formulario->respostas()
            ->with('valores.campo')
            ->latest()
            ->paginate(20);

        return view('eventos.formularios.respostas.index', compact('evento', 'formulario', 'respostas'));
    }

    /**
     * Exibe uma resposta específica
     */
    public function show(Evento $evento, EventoFormulario $formulario, FormularioResposta $resposta)
    {
        $resposta->load('valores.campo');

        return view('eventos.formularios.respostas.show', compact('evento', 'formulario', 'resposta'));
    }

    /**
     * Remove uma resposta
     */
    public function destroy(Evento $evento, EventoFormulario $formulario, FormularioResposta $resposta)
    {
        $resposta->delete();

        return back()->with('success', 'Resposta removida com sucesso!');
    }

    /**
     * Exporta respostas para CSV
     */
    public function export(Evento $evento, EventoFormulario $formulario)
    {
        $respostas = $formulario->respostas()->with('valores.campo')->get();
        $campos = $formulario->campos()->orderBy('ordem')->get();

        $filename = "respostas-{$formulario->slug}-" . now()->format('Y-m-d') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($respostas, $campos) {
            $file = fopen('php://output', 'w');

            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Cabeçalho
            $header = array_merge(
                ['Data de Envio', 'IP'],
                $campos->pluck('label')->toArray()
            );
            fputcsv($file, $header, ';');

            // Dados
            foreach ($respostas as $resposta) {
                $row = [
                    $resposta->created_at->format('d/m/Y H:i:s'),
                    $resposta->ip_origem
                ];

                foreach ($campos as $campo) {
                    $valor = $resposta->valores->firstWhere('campo_id', $campo->id);
                    $row[] = $valor ? $valor->valor : '';
                }

                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
