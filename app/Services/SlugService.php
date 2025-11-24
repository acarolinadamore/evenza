<?php

namespace App\Services;

use App\Models\Evento;
use Illuminate\Support\Str;

class SlugService
{
    /**
     * Gera um slug único para um evento
     */
    public static function gerarSlugUnico(string $nome, ?int $eventoId = null): string
    {
        $slug = Str::slug($nome);
        $slugOriginal = $slug;
        $contador = 1;

        // Verifica se o slug já existe (excluindo o próprio evento se estiver editando)
        while (self::slugExiste($slug, $eventoId)) {
            $slug = $slugOriginal . '-' . $contador;
            $contador++;
        }

        return $slug;
    }

    /**
     * Verifica se um slug já existe
     */
    private static function slugExiste(string $slug, ?int $eventoIdExcluir = null): bool
    {
        $query = Evento::where('slug', $slug);

        if ($eventoIdExcluir) {
            $query->where('id', '!=', $eventoIdExcluir);
        }

        return $query->exists();
    }

    /**
     * Atualiza o slug de um evento se o nome mudou
     */
    public static function atualizarSlug(Evento $evento, string $novoNome): void
    {
        $novoSlug = self::gerarSlugUnico($novoNome, $evento->id);

        if ($evento->slug !== $novoSlug) {
            $evento->slug = $novoSlug;
            $evento->save();
        }
    }
}
