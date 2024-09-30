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
            $table->string('pais_nacimiento', 50)->nullable();
            $table->string('nacionalidad', 255)->nullable();

            $table->string('telefono_personal', 15)->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('correo_personal', 200)->nullable();
            $table->string('correo_institucional', 200)->nullable();
            

            // Direccion / Colegio
            $table->string('ubigeodepartamento_id', 2)->nullable();
            $table->foreign('ubigeodepartamento_id')->references('id')->on('ubigeodepartamento')->onDelete('set null');

            $table->string('ubigeoprovincia_id', 4)->nullable();
            $table->foreign('ubigeoprovincia_id')->references('id')->on('ubigeoprovincia')->onDelete('set null');

            $table->string('ubigeodistrito_id', 6)->nullable();
            $table->foreign('ubigeodistrito_id')->references('id')->on('ubigeodistrito')->onDelete('set null');

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
