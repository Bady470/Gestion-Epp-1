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
    Schema::create('elementos_pp', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 45);
        $table->string('descripcion', 255)->nullable();
        $table->string('img_url', 100)->nullable();
        $table->integer('cantidad')->default(0);
        $table->string('talla')->nullable();

        $table->unsignedBigInteger('areas_id')->nullable();
        $table->unsignedBigInteger('filtros_id')->nullable();

        $table->timestamps();

        $table->foreign('areas_id')->references('id')->on('areas')->onDelete('set null');
        $table->foreign('filtros_id')->references('id')->on('filtros')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementos_pp');
    }
};