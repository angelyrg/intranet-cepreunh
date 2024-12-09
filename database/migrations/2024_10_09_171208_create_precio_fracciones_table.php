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
        Schema::create('precio_fracciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('precio_id');
            $table->foreign('precio_id')->references('id')->on('precios')->onDelete('cascade');

            $table->decimal('monto', 10, 2);
            $table->date('fecha_limite')->nullable();

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precio_fracciones');
    }
};
