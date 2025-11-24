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
        Schema::create('formulario_campos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulario_id')->constrained('evento_formularios')->onDelete('cascade');
            $table->enum('tipo', ['nome', 'email', 'telefone', 'select', 'checkbox', 'radio', 'textarea', 'mensagem']);
            $table->string('label');
            $table->string('placeholder')->nullable();
            $table->json('opcoes')->nullable();
            $table->boolean('obrigatorio')->default(false);
            $table->integer('ordem')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulario_campos');
    }
};
