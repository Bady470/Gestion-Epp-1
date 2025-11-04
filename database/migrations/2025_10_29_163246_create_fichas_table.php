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
    Schema::create('fichas', function (Blueprint $table) {
        $table->id();
        $table->string('numero', 45);
        $table->unsignedBigInteger('programas_id')->nullable();
        $table->timestamps();

        $table->foreign('programas_id')->references('id')->on('programas')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas');
    }
};