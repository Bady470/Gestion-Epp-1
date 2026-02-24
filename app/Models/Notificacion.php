<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $fillable = [
        'user_id',
        'tipo',
        'titulo',
        'mensaje',
        'solicitud_id',
        'pedido_id',
        'usuario_accion_id',
        'leida',
        'fecha_lectura',
        'correo_enviado',
        'fecha_envio_correo',
        'datos_adicionales',
    ];

    protected $casts = [
        'leida' => 'boolean',
        'correo_enviado' => 'boolean',
        'fecha_lectura' => 'datetime',
        'fecha_envio_correo' => 'datetime',
        'datos_adicionales' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación: La notificación pertenece a un usuario (líder que la recibe)
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: La notificación pertenece a una solicitud
     */
    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class);
    }

    /**
     * Relación: La notificación pertenece a un pedido
     */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    /**
     * Relación: La notificación fue generada por un usuario (quien realizó la acción)
     */
    public function usuarioAccion(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_accion_id');
    }

    /**
     * Marcar la notificación como leída
     */
    public function marcarComoLeida(): void
    {
        $this->update([
            'leida' => true,
            'fecha_lectura' => now(),
        ]);
    }

    /**
     * Marcar la notificación como no leída
     */
    public function marcarComoNoLeida(): void
    {
        $this->update([
            'leida' => false,
            'fecha_lectura' => null,
        ]);
    }

    /**
     * Marcar el correo como enviado
     */
    public function marcarCorreoEnviado(): void
    {
        $this->update([
            'correo_enviado' => true,
            'fecha_envio_correo' => now(),
        ]);
    }

    /**
     * Obtener las notificaciones no leídas de un usuario
     */
    public static function notificacionesNoLeidas($userId)
    {
        return self::where('user_id', $userId)
            ->where('leida', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Obtener el conteo de notificaciones no leídas
     */
    public static function contarNoLeidas($userId)
    {
        return self::where('user_id', $userId)
            ->where('leida', false)
            ->count();
    }
}
