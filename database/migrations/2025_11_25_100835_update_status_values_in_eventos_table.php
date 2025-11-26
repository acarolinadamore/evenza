<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remover constraint antiga primeiro
        DB::statement("ALTER TABLE eventos DROP CONSTRAINT IF EXISTS eventos_status_check");

        // Alterar coluna para varchar temporariamente
        DB::statement("ALTER TABLE eventos ALTER COLUMN status TYPE VARCHAR(50)");

        // Converter valores antigos para novos
        DB::statement("UPDATE eventos SET status = 'publicado' WHERE status = 'em_andamento'");
        DB::statement("UPDATE eventos SET status = 'finalizado' WHERE status = 'concluido'");

        // Adicionar nova constraint
        DB::statement("ALTER TABLE eventos ADD CONSTRAINT eventos_status_check CHECK (status IN ('rascunho', 'publicado', 'inscricoes_encerradas', 'finalizado', 'cancelado'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter para valores antigos
        DB::statement("UPDATE eventos SET status = 'em_andamento' WHERE status = 'publicado'");
        DB::statement("UPDATE eventos SET status = 'concluido' WHERE status = 'finalizado'");

        DB::statement("ALTER TABLE eventos DROP CONSTRAINT IF EXISTS eventos_status_check");
        DB::statement("ALTER TABLE eventos ADD CONSTRAINT eventos_status_check CHECK (status IN ('rascunho', 'em_andamento', 'concluido'))");
    }
};
