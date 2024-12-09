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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_documento_id')->default(1); //1:DNI
            $table->foreign('tipo_documento_id')->references('id')->on('tipos_documentos');

            $table->string('nro_documento', 50);
            $table->string('nombres', 150)->nullable();
            $table->string('apellido_paterno', 100)->nullable();
            $table->string('apellido_materno', 100)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('pais_nacimiento', 50)->nullable();

            $table->string('telefono_personal', 20)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->string('correo_personal', 200)->nullable();
            $table->string('correo_institucional', 200)->nullable();

            $table->unsignedBigInteger('departamento_id')->default(1);
            $table->foreign('departamento_id')->references('id')->on('departamentos');

            
            // user
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('empleados');
    }
};
