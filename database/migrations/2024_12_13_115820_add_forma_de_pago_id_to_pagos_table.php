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
        Schema::table('pagos', function (Blueprint $table) {
            $table->unsignedBigInteger('forma_de_pago_id')->nullable()->after('condicion_pago');
            $table->foreign('forma_de_pago_id')->references('id')->on('formas_de_pago')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropForeign(['forma_de_pago_id']);
            $table->dropColumn('forma_de_pago_id');
        });
    }
};
