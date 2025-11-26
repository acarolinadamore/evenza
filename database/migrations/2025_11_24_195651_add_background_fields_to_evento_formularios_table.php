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
        Schema::table('evento_formularios', function (Blueprint $table) {
            $table->boolean('exibir_landing_page')->default(false)->after('ativo');
            $table->string('background_cor', 7)->nullable()->after('exibir_landing_page');
            $table->string('background_imagem')->nullable()->after('background_cor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evento_formularios', function (Blueprint $table) {
            $table->dropColumn(['exibir_landing_page', 'background_cor', 'background_imagem']);
        });
    }
};
