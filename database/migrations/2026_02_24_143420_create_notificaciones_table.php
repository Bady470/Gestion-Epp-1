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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();

            // Usuario que recibe la notificación (líder)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Tipo de notificación (solicitud_epp, pedido_aprobado, pedido_rechazado, etc.)
            $table->string('tipo')->default('solicitud_epp');

            // Título de la notificación
            $table->string('titulo');

            // Descripción o mensaje de la notificación
            $table->text('mensaje');

            // Referencia a la solicitud que generó la notificación
            $table->foreignId('solicitud_id')->nullable()->constrained('solicitudes')->onDelete('cascade');

            // Referencia al pedido (opcional)
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('cascade');

            // Usuario que realizó la acción que generó la notificación
            $table->foreignId('usuario_accion_id')->nullable()->constrained('users')->onDelete('set null');

            // Estado de lectura de la notificación
            $table->boolean('leida')->default(false);

            // Fecha en que se marcó como leída
            $table->timestamp('fecha_lectura')->nullable();

            // Estado de envío de correo
            $table->boolean('correo_enviado')->default(false);

            // Fecha en que se envió el correo
            $table->timestamp('fecha_envio_correo')->nullable();

            // Datos adicionales en JSON (para información flexible)
            $table->json('datos_adicionales')->nullable();

            // Timestamps
            $table->timestamps();

            // Índices para optimizar búsquedas
            $table->index('user_id');
            $table->index('leida');
            $table->index('tipo');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
