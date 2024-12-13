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
            $table->string('modalidad_estudio', 15)->default('Presencial')->after('sede_id');
            $table->tinyInteger('modalidad_matricula')->default(1)->after('modalidad_estudio');
            $table->string('condicion_academica', 15)->default('Egresado')->after('modalidad_matricula');
            $table->tinyInteger('cantidad_matricula')->default(1)->after('condicion_academica');
            
            $table->dropForeign(['apoderado_id']);
            $table->dropColumn(['apoderado_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropColumn(['modalidad_estudio', 'modalidad_matricula', 'condicion_academica', 'cantidad_matricula']);

            $table->unsignedBigInteger('apoderado_id')->nullable();
            $table->foreign('apoderado_id')->references('id')->on('apoderados');
        });
    }
};
