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
        Schema::table('participantes', function (Blueprint $table) {
            $table->text('observacoes')->nullable()->after('is_whatsapp');
            $table->date('data_nascimento')->nullable()->after('observacoes');
            $table->enum('sexo', ['feminino', 'masculino', 'nao_informado'])->default('nao_informado')->after('data_nascimento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->dropColumn(['observacoes', 'data_nascimento', 'sexo']);
        });
    }
};
