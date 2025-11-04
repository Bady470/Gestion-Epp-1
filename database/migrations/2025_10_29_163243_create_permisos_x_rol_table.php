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
    Schema::create('permisos_x_rol', function (Blueprint $table) {
        $table->unsignedBigInteger('roles_id');
        $table->unsignedBigInteger('permisos_id');

        $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
        $table->foreign('permisos_id')->references('id')->on('permisos')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos_x_rol');
    }
};