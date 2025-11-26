<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Adicionar is_whatsapp apenas se não existir em participantes
        if (!Schema::hasColumn('participantes', 'is_whatsapp')) {
            Schema::table('participantes', function (Blueprint $table) {
                $table->boolean('is_whatsapp')->default(true)->after('telefone');
            });
        }

        Schema::table('evento_organizadores', function (Blueprint $table) {
            $table->boolean('is_whatsapp')->default(true)->after('telefone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->dropColumn('is_whatsapp');
        });

        Schema::table('evento_organizadores', function (Blueprint $table) {
            $table->dropColumn('is_whatsapp');
        });
    }
};
