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
        // Remover a constraint de verificação do sexo
        DB::statement('ALTER TABLE participantes DROP CONSTRAINT IF EXISTS participantes_sexo_check');

        // Limpar dados antigos (converter 'Outro' ou qualquer valor diferente de M/F para NULL)
        DB::statement("UPDATE participantes SET sexo = NULL WHERE sexo NOT IN ('M', 'F')");

        // Alterar a coluna para varchar sem constraint
        DB::statement('ALTER TABLE participantes ALTER COLUMN sexo TYPE VARCHAR(1)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recriar a constraint antiga
        DB::statement("ALTER TABLE participantes ADD CONSTRAINT participantes_sexo_check CHECK (sexo IN ('M', 'F', 'Outro'))");
    }
};
