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
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 20);
            $table->tinyInteger('piso')->default(1);
            $table->integer('aforo')->default(30);

            $table->unsignedBigInteger('sede_id')->nullable();
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aulas');
    }
};
