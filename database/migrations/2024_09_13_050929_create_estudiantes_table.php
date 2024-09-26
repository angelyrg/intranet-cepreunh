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
        // Schema::create('estudiantes', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });

        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento', 50);
            $table->string('nro_documento', 50);
            $table->string('nombres', 150);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100)->nullable();
            $table->string('pais_nacimiento', 50);
            $table->string('nacionalidad', 255);

            $table->string('telefono_personal', 15)->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('telefono_apoderado', 15)->nullable();
            $table->string('correo_personal', 200)->nullable();
            $table->string('correo_institucional', 200)->nullable();

            $table->string('tipo_colegio', 100)->nullable();
            $table->string('nombre_colegio', 255)->nullable();
            $table->string('year_culminacion', 4)->nullable();

            $table->string('departamento', 50);
            $table->string('provincia', 50);
            $table->string('distrito', 50);
            $table->string('direccion', 255);

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
