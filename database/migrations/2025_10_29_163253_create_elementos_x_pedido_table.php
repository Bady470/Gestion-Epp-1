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
    Schema::create('elementos_x_pedido', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pedidos_id');
        $table->unsignedBigInteger('elementos_pp_id');

        $table->foreign('pedidos_id')->references('id')->on('pedidos')->onDelete('cascade');
        $table->foreign('elementos_pp_id')->references('id')->on('elementos_pp')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementos_x_pedido');
    }
};