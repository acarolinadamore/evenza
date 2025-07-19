<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('eventos', function (Blueprint $table) {
        $table->id();
        $table->string('nome', 300);                    
        $table->string('descricao', 1000)->nullable();
        $table->date('data_evento')->nullable(); 
        $table->string('local', 500)->nullable(); 
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};