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
    Schema::create('programas', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 255);
        $table->unsignedBigInteger('areas_id')->nullable();
        $table->string('nivel',45);
        $table->timestamps();

        $table->foreign('areas_id')->references('id')->on('areas')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programas');
    }
};
