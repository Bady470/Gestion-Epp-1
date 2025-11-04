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
    Schema::create('pedidos_has_solicitudes', function (Blueprint $table) {
        $table->unsignedBigInteger('pedidos_id');
        $table->unsignedBigInteger('solicitudes_id');

        $table->foreign('pedidos_id')->references('id')->on('pedidos')->onDelete('cascade');
        $table->foreign('solicitudes_id')->references('id')->on('solicitudes')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos_has_solicitudes');
    }
};