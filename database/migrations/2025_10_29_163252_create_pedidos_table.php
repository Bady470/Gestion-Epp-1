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
    Schema::create('pedidos', function (Blueprint $table) {
        $table->id();
        $table->date('fecha')->nullable();

        $table->unsignedBigInteger('users_id')->nullable();
        $table->unsignedBigInteger('fichas_id')->nullable();
        $table->string('estado')->nullable();
        

        $table->timestamps();

        $table->foreign('users_id')->references('id')->on('users')->onDelete('set null');
        $table->foreign('fichas_id')->references('id')->on('fichas')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};