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
        Schema::table('matriculas', function (Blueprint $table) {
            $table->unsignedBigInteger('aula_ciclo_actual_id')->nullable()->after('usuario_registro_id');
            $table->foreign('aula_ciclo_actual_id')->references('id')->on('aula_ciclo')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropForeign(['aula_ciclo_actual_id']);
            $table->dropColumn('aula_ciclo_actual_id');
        });
    }
};