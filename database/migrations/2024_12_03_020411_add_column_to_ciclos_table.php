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
        Schema::table('ciclos', function (Blueprint $table) {
            $table->string('dias_lectivos', 13)->nullable()->after('duracion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ciclos', function (Blueprint $table) {
            $table->dropColumn('dias_lectivos');
        });
    }
};
