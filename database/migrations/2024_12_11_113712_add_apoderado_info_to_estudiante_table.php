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
            $table->string('telefono_apoderado', 15)->nullable();
            $table->string('correo_apoderado', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            if (Schema::hasColumn('estudiantes', 'telefono_apoderado')) {
                $table->dropColumn('telefono_apoderado');
            }

            if (Schema::hasColumn('estudiantes', 'correo_apoderado')) {
                $table->dropColumn('correo_apoderado');
            }
        });
    }
};
