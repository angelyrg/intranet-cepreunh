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
            $table->dropColumn([
                'discapacidades',
                'telefono_apoderado',
                'correo_apoderado'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->text('discapacidades')->nullable();
            $table->string('telefono_apoderado', 15)->nullable();
            $table->string('correo_apoderado', 100)->nullable();
        });
    }
};
