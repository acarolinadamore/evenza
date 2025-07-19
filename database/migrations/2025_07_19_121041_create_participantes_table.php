<?php
// database/migrations/2025_01_20_create_participantes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('participantes', function (Blueprint $table) {
        $table->id();
        $table->string('nome', 300);                       
        $table->string('email', 300)->nullable();     
        $table->string('telefone', 50)->nullable();   
        $table->foreignId('evento_id')->nullable()->constrained('eventos');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};