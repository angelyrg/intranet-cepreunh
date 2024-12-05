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
        Schema::create('carreras_grupos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('grupo_id')->nullable();
            $table->foreign('grupo_id')->references('id')->on('grupo_precios');
            
            $table->unsignedBigInteger('carrara_id')->nullable();
            $table->foreign('carrara_id')->references('id')->on('carreras');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carreras_grupos');
    }
};
