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
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->unsignedBigInteger('sede_actual_id')->default(1)->nullable()->after('apoderado_id');
            $table->foreign('sede_actual_id')->references('id')->on('sedes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropForeign(['sede_actual_id']);
            $table->dropColumn(['sede_actual_id']);
        });
    }
};
