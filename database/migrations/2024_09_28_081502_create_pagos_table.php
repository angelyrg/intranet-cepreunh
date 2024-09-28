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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('matricula_id')->nullable();
            $table->foreign('matricula_id')->references('id')->on('matriculas');

            $table->string('banco', 100);
            $table->string('cod_operacion', 100)->nullable();
            $table->string('descripcion_pago', 100)->nullable();
            $table->dateTime('fecha_pago');
            $table->string('n_transaccion', 100)->nullable();
            $table->decimal('monto', 10, 2);
            $table->decimal('comision', 10, 2);
            $table->decimal('monto_neto', 10, 2);

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
