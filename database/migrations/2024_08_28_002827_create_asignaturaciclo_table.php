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
        // Schema::create('asignatura_ciclo', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('ciclo_id')->constrained('ciclos');
        //     $table->foreignId('asignatura_id')->constrained('asignaturas');
        //     $table->boolean('estado')->default(true); 
        //     $table->timestamps();
        // });

        Schema::create('asignatura_ciclo', function (Blueprint $table) {
            
            $table->increments('id');
            $table->unsignedBigInteger('ciclo_id');
            $table->unsignedBigInteger('asignatura_id');
            $table->boolean('estado')->default(true); 
            $table->timestamps();
        
            $table->foreign('ciclo_id')->references('id')->on('ciclos');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignatura_ciclo');
    }
};
