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
        Schema::create('resposta_valores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resposta_id')->constrained('formulario_respostas')->onDelete('cascade');
            $table->foreignId('campo_id')->constrained('formulario_campos')->onDelete('cascade');
            $table->text('valor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resposta_valores');
    }
};
