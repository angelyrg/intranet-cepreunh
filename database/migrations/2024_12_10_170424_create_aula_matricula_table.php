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
        Schema::create('aula_matricula', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('matricula_id')->nullable();
            $table->foreign('matricula_id')->references('id')->on('matriculas')->onDelete('cascade');

            $table->unsignedBigInteger('aula_ciclo_id')->nullable();
            $table->foreign('aula_ciclo_id')->references('id')->on('aula_ciclo')->onDelete('cascade');

            $table->tinyInteger('estado')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aula_matricula');
    }
};
