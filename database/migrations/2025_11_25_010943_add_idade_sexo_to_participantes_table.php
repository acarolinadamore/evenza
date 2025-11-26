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
            if (!Schema::hasColumn('participantes', 'idade')) {
                $table->integer('idade')->nullable()->after('is_whatsapp');
            }
            if (!Schema::hasColumn('participantes', 'sexo')) {
                $table->string('sexo', 1)->nullable()->after('idade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->dropColumn(['idade', 'sexo']);
        });
    }
};
