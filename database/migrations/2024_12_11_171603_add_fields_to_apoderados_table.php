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
        Schema::table('apoderados', function (Blueprint $table) {
            //Datos personales
            $table->unsignedBigInteger('tipo_documento_id')->nullable()->after('id');
            $table->foreign('tipo_documento_id')->references('id')->on('tipos_documentos')->onDelete('set null');

            $table->string('nro_documento', 8)->nullable()->after('tipo_documento_id');
            $table->string('nombres', 150)->nullable()->after('nro_documento');
            $table->string('apellido_paterno', 100)->nullable()->after('nombres');
            $table->string('apellido_materno', 100)->nullable()->after('apellido_paterno');

            $table->string('telefono_apoderado', 9)->nullable()->after('apellido_materno');
            $table->string('correo_apoderado', 200)->nullable()->after('telefono_apoderado');

            $table->unsignedBigInteger('parentesco_id')->nullable()->after('correo_apoderado');
            $table->foreign('parentesco_id')->references('id')->on('parentescos')->onDelete('set null');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apoderados', function (Blueprint $table) {
            $table->dropForeign(['tipo_documento_id']);

            $table->dropColumn([
                'tipo_documento_id',
                'nro_documento',
                'nombres',
                'apellido_paterno',
                'apellido_materno',
                'telefono_apoderado',
                'correo_apoderado',
                'parentesco_id',
                'deleted_at'
            ]);
        });
    }
};
