<?php

namespace App\Http\Controllers;

use App\Models\EventoFormulario;
use App\Models\FormularioResposta;
use App\Models\RespostaValor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormularioPublicoController extends Controller
{
    /**
     * Submete uma resposta de formulário público
     */
    public function submit(Request $request, string $eventoSlug, string $formularioSlug)
    {
        // Rate limiting básico
        $ip = $request->ip();
        $recentSubmissions = FormularioResposta::where('ip_origem', $ip)
            ->where('created_at', '>', now()->subMinutes(5))
            ->count();

        if ($recentSubmissions >= 3) {
            return back()->with('error', 'Muitas tentativas. Por favor, aguarde alguns minutos.');
        }

        // Busca o formulário
        $formulario = EventoFormulario::where('slug', $formularioSlug)
            ->whereHas('evento', function ($query) use ($eventoSlug) {
                $query->where('slug', $eventoSlug)
                    ->where('landing_page_ativa', true);
            })
            ->where('ativo', true)
            ->with('campos', 'evento')
            ->firstOrFail();

        // Valida os campos
        $rules = [];
        $messages = [];

        foreach ($formulario->campos as $campo) {
            $fieldName = "campo_{$campo->id}";

            if ($campo->obrigatorio) {
                $rules[$fieldName] = 'required';
                $messages["{$fieldName}.required"] = "O campo {$campo->label} é obrigatório.";
            }

            // Validações específicas por tipo
            switch ($campo->tipo) {
                case 'email':
                    $rules[$fieldName] = ($rules[$fieldName] ?? '') . '|email';
                    $messages["{$fieldName}.email"] = "O campo {$campo->label} deve ser um e-mail válido.";
                    break;
                case 'telefone':
                    $rules[$fieldName] = ($rules[$fieldName] ?? '') . '|min:10|max:15';
                    break;
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Salva a resposta
        DB::beginTransaction();
        try {
            $resposta = FormularioResposta::create([
                'formulario_id' => $formulario->id,
                'evento_id' => $formulario->evento_id,
                'ip_origem' => $ip,
                'user_agent' => $request->userAgent()
            ]);

            foreach ($formulario->campos as $campo) {
                $fieldName = "campo_{$campo->id}";
                $valor = $request->input($fieldName);

                if ($valor !== null) {
                    RespostaValor::create([
                        'resposta_id' => $resposta->id,
                        'campo_id' => $campo->id,
                        'valor' => is_array($valor) ? json_encode($valor) : $valor
                    ]);
                }
            }

            DB::commit();

            $mensagem = $formulario->mensagem_sucesso ?? 'Formulário enviado com sucesso!';
            return back()->with('success', $mensagem);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao enviar formulário. Tente novamente.');
        }
    }
}
