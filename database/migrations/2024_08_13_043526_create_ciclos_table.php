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
        Schema::create('ciclos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 255);

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->tinyInteger('duracion');

            $table->unsignedBigInteger('tipos_ciclos_id');
            $table->foreign('tipos_ciclos_id')->references('id')->on('tipos_ciclos')->onDelete('cascade');

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
        Schema::dropIfExists('ciclos');
    }
};
