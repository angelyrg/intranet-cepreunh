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
        // Schema::create('carrera_ciclo', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('ciclo_id')->constrained('ciclos');
        //     $table->foreignId('carrera_id')->constrained('asignaciones');
        //     $table->boolean('estado')->default(true); 
        //     $table->timestamps();
        // });

        Schema::create('carrera_ciclo', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('ciclo_id');
            $table->unsignedBigInteger('carrera_id');
            $table->boolean('estado')->default(true); 
            $table->timestamps();
        
            $table->foreign('ciclo_id')->references('id')->on('ciclos');
            $table->foreign('carrera_id')->references('id')->on('carreras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrera_ciclo');
    }
};
