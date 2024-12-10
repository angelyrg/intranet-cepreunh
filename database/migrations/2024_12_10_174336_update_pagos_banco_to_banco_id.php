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
            $table->dropColumn('banco');

            $table->unsignedBigInteger('banco_id')->nullable();
            $table->foreign('banco_id')->references('id')->on('bancos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->string('banco', 100)->nullable();
            $table->dropColumn('banco_id');
        });
    }
};
