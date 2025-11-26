<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoFormulario;
use App\Models\FormularioCampo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventoFormularioController extends Controller
{
    /**
     * Lista os formulários de um evento
     */
    public function index(Evento $evento)
    {
        $formularios = $evento->formularios()->with('campos')->orderBy('ordem')->get();

        return view('eventos.formularios.index', compact('evento', 'formularios'));
    }

    /**
     * Exibe o formulário de criação
     */
    public function create(Evento $evento)
    {
        return view('eventos.formularios.create', compact('evento'));
    }

    /**
     * Armazena um novo formulário
     */
    public function store(Request $request, Evento $evento)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'mensagem_sucesso' => 'nullable|string|max:500',
            'ativo' => 'boolean',
            'campos' => 'required|array|min:1',
            'campos.*.tipo' => 'required|in:nome,email,telefone,select,checkbox,radio,textarea,mensagem',
            'campos.*.label' => 'required|string|max:255',
            'campos.*.placeholder' => 'nullable|string|max:255',
            'campos.*.opcoes' => 'nullable|array',
            'campos.*.obrigatorio' => 'boolean'
        ]);

        DB::beginTransaction();
        try {
            $ordem = $evento->formularios()->max('ordem') + 1;
            $slug = $this->gerarSlugUnico($request->input('nome'), $evento->id);

            $formulario = EventoFormulario::create([
                'evento_id' => $evento->id,
                'nome' => $request->input('nome'),
                'slug' => $slug,
                'mensagem_sucesso' => $request->input('mensagem_sucesso'),
                'ordem' => $ordem,
                'ativo' => $request->boolean('ativo', true)
            ]);

            foreach ($request->input('campos') as $index => $campoData) {
                FormularioCampo::create([
                    'formulario_id' => $formulario->id,
                    'tipo' => $campoData['tipo'],
                    'label' => $campoData['label'],
                    'placeholder' => $campoData['placeholder'] ?? null,
                    'opcoes' => $campoData['opcoes'] ?? null,
                    'obrigatorio' => $campoData['obrigatorio'] ?? false,
                    'ordem' => $index
                ]);
            }

            DB::commit();

            return redirect()->route('eventos.formularios.index', $evento)
                ->with('success', 'Formulário criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao criar formulário.')->withInput();
        }
    }

    /**
     * Exibe o formulário de edição
     */
    public function edit(Evento $evento, EventoFormulario $formulario)
    {
        $formulario->load('campos');

        return view('eventos.formularios.edit', compact('evento', 'formulario'));
    }

    /**
     * Atualiza um formulário existente
     */
    public function update(Request $request, Evento $evento, EventoFormulario $formulario)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'mensagem_sucesso' => 'nullable|string|max:500',
            'ativo' => 'boolean',
            'background_cor' => 'nullable|string|max:7',
            'background_imagem' => 'nullable|image|max:2048',
            'campos' => 'required|array|min:1',
            'campos.*.tipo' => 'required|in:nome,email,telefone,select,checkbox,radio,textarea,mensagem',
            'campos.*.label' => 'required|string|max:255',
            'campos.*.placeholder' => 'nullable|string|max:255',
            'campos.*.opcoes' => 'nullable|array',
            'campos.*.obrigatorio' => 'boolean'
        ]);

        DB::beginTransaction();
        try {
            $slug = $this->gerarSlugUnico($request->input('nome'), $evento->id, $formulario->id);

            $data = [
                'nome' => $request->input('nome'),
                'slug' => $slug,
                'mensagem_sucesso' => $request->input('mensagem_sucesso'),
                'ativo' => $request->boolean('ativo')
            ];

            // Processar cor de fundo
            if ($request->boolean('remover_background_cor')) {
                $data['background_cor'] = null;
            } else {
                $data['background_cor'] = $request->input('background_cor');
            }

            // Processar imagem de fundo
            if ($request->hasFile('background_imagem')) {
                // Remover imagem antiga se existir
                if ($formulario->background_imagem) {
                    Storage::disk('public')->delete($formulario->background_imagem);
                }
                $data['background_imagem'] = $request->file('background_imagem')->store('formularios/backgrounds', 'public');
            }

            // Remover imagem se solicitado
            if ($request->boolean('remover_background_imagem') && $formulario->background_imagem) {
                Storage::disk('public')->delete($formulario->background_imagem);
                $data['background_imagem'] = null;
            }

            $formulario->update($data);

            // Remove campos antigos
            $formulario->campos()->delete();

            // Recria campos
            foreach ($request->input('campos') as $index => $campoData) {
                FormularioCampo::create([
                    'formulario_id' => $formulario->id,
                    'tipo' => $campoData['tipo'],
                    'label' => $campoData['label'],
                    'placeholder' => $campoData['placeholder'] ?? null,
                    'opcoes' => $campoData['opcoes'] ?? null,
                    'obrigatorio' => $campoData['obrigatorio'] ?? false,
                    'ordem' => $index
                ]);
            }

            DB::commit();

            return back()->with('success', 'Formulário atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar formulário.')->withInput();
        }
    }

    /**
     * Remove um formulário
     */
    public function destroy(Evento $evento, EventoFormulario $formulario)
    {
        $formulario->delete();

        return back()->with('success', 'Formulário removido com sucesso!');
    }

    /**
     * Reordena os formulários
     */
    public function reorder(Request $request, Evento $evento)
    {
        $request->validate([
            'formularios' => 'required|array',
            'formularios.*' => 'exists:evento_formularios,id'
        ]);

        foreach ($request->input('formularios') as $ordem => $formularioId) {
            EventoFormulario::where('id', $formularioId)
                ->where('evento_id', $evento->id)
                ->update(['ordem' => $ordem]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Atualiza configurações de landing page do formulário
     */
    public function updateLandingPageConfig(Request $request, Evento $evento, EventoFormulario $formulario)
    {
        $data = [];

        if ($request->has('exibir_landing_page')) {
            $data['exibir_landing_page'] = $request->boolean('exibir_landing_page');
        }

        if ($request->has('background_cor')) {
            $data['background_cor'] = $request->input('background_cor');
        }

        if ($request->has('background_imagem')) {
            $data['background_imagem'] = $request->input('background_imagem');
        }

        $formulario->update($data);

        return response()->json(['success' => true]);
    }

    /**
     * Gera slug único para o formulário
     */
    private function gerarSlugUnico(string $nome, int $eventoId, ?int $formularioIdExcluir = null): string
    {
        $slug = Str::slug($nome);
        $slugOriginal = $slug;
        $contador = 1;

        while ($this->slugExiste($slug, $eventoId, $formularioIdExcluir)) {
            $slug = $slugOriginal . '-' . $contador;
            $contador++;
        }

        return $slug;
    }

    /**
     * Verifica se o slug já existe para o evento
     */
    private function slugExiste(string $slug, int $eventoId, ?int $formularioIdExcluir = null): bool
    {
        $query = EventoFormulario::where('evento_id', $eventoId)
            ->where('slug', $slug);

        if ($formularioIdExcluir) {
            $query->where('id', '!=', $formularioIdExcluir);
        }

        return $query->exists();
    }
}
