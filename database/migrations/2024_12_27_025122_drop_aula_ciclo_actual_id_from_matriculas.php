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
            $table->dropForeign(['aula_ciclo_actual_id']);
            $table->dropColumn('aula_ciclo_actual_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            // Volver a agregar la columna 'aula_ciclo_actual_id'
            $table->unsignedBigInteger('aula_ciclo_actual_id')->nullable()->after('usuario_registro_id');

            // Volver a agregar la clave foránea
            $table->foreign('aula_ciclo_actual_id')->references('id')->on('aula_ciclo')->onDelete('set null');
        });
    }
};
