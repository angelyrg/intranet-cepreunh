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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            //Datos personales
            $table->unsignedBigInteger('tipo_documento_id')->default(1); //1:DNI
            $table->foreign('tipo_documento_id')->references('id')->on('tipos_documentos');

            $table->string('nro_documento', 50);
            $table->string('nombres', 150)->nullable();
            $table->string('apellido_paterno', 100)->nullable();
            $table->string('apellido_materno', 100)->nullable();

            $table->unsignedBigInteger('genero_id')->nullable();
            $table->foreign('genero_id')->references('id')->on('generos')->onDelete('set null');

            $table->unsignedBigInteger('estado_civil_id')->nullable();
            $table->foreign('estado_civil_id')->references('id')->on('estados_civiles')->onDelete('set null');

            $table->date('fecha_nacimiento')->nullable();
            $table->string('pais_nacimiento', 50)->nullable();
            $table->string('nacionalidad', 255)->nullable();

            $table->string('telefono_personal', 15)->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('correo_personal', 200)->nullable();
            $table->string('correo_institucional', 200)->nullable();

            $table->boolean('discapacidad')->nullable()->default(false);
            $table->text('discapacid_detalle')->nullable();

            $table->unsignedBigInteger('identidad_etnica_id')->nullable();
            $table->foreign('identidad_etnica_id')->references('id')->on('identidades_etnicas')->onDelete('set null');

            // Lugar de nacimiento
            $table->string('nacimiento_ubigeodepartamento_id', 2)->nullable();
            $table->foreign('nacimiento_ubigeodepartamento_id')->references('id')->on('ubigeodepartamento')->onDelete('set null');

            $table->string('nacimiento_ubigeoprovincia_id', 4)->nullable();
            $table->foreign('nacimiento_ubigeoprovincia_id')->references('id')->on('ubigeoprovincia')->onDelete('set null');

            $table->string('nacimiento_ubigeodistrito_id', 6)->nullable();
            $table->foreign('nacimiento_ubigeodistrito_id')->references('id')->on('ubigeodistrito')->onDelete('set null');


            // Direccion / Colegio
            $table->string('direccion_ubigeodepartamento_id', 2)->nullable();
            $table->foreign('direccion_ubigeodepartamento_id')->references('id')->on('ubigeodepartamento')->onDelete('set null');

            $table->string('direccion_ubigeoprovincia_id', 4)->nullable();
            $table->foreign('direccion_ubigeoprovincia_id')->references('id')->on('ubigeoprovincia')->onDelete('set null');

            $table->string('direccion_ubigeodistrito_id', 6)->nullable();
            $table->foreign('direccion_ubigeodistrito_id')->references('id')->on('ubigeodistrito')->onDelete('set null');

            $table->string('direccion', 255)->nullable();

            $table->integer('colegio_id')->nullable();
            $table->foreign('colegio_id')->references('id')->on('colegios')->onDelete('set null');
            $table->string('year_culminacion', 4)->nullable();

            // Apoderado
            $table->unsignedBigInteger('apoderado_id')->nullable();
            $table->foreign('apoderado_id')->references('id')->on('apoderados')->onDelete('set null');


            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
