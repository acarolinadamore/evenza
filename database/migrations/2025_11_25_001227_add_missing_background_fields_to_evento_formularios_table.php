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
            if (!Schema::hasColumn('evento_formularios', 'exibir_landing_page')) {
                $table->boolean('exibir_landing_page')->default(false)->after('ativo');
            }
            if (!Schema::hasColumn('evento_formularios', 'background_cor')) {
                $table->string('background_cor', 7)->nullable()->after('exibir_landing_page');
            }
            if (!Schema::hasColumn('evento_formularios', 'background_imagem')) {
                $table->string('background_imagem')->nullable()->after('background_cor');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evento_formularios', function (Blueprint $table) {
            if (Schema::hasColumn('evento_formularios', 'exibir_landing_page')) {
                $table->dropColumn('exibir_landing_page');
            }
            if (Schema::hasColumn('evento_formularios', 'background_cor')) {
                $table->dropColumn('background_cor');
            }
            if (Schema::hasColumn('evento_formularios', 'background_imagem')) {
                $table->dropColumn('background_imagem');
            }
        });
    }
};
