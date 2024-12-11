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
            $table->string('colegio_ubigeodistrito_id', 6)->nullable()->after('direccion');
            $table->foreign('colegio_ubigeodistrito_id')->references('id')->on('ubigeodistrito')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropForeign(['colegio_ubigeodistrito_id']);
            $table->dropColumn(['colegio_ubigeodistrito_id']);
        });
    }
};
