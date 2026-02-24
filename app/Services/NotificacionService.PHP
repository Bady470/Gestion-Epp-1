<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\User;
use App\Models\Solicitud;
use App\Models\Pedido;
use App\Mail\NotificacionSolicitudEPP;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificacionService
{
    /**
     * Crear una notificación de nueva solicitud de EPP
     *
     * @param Solicitud $solicitud
     * @param User $usuarioAccion
     * @return Notificacion
     */
    public function crearNotificacionSolicitudEPP(Solicitud $solicitud, User $usuarioAccion): Notificacion
    {
        // Obtener los líderes del área de la solicitud
        $lideres = $this->obtenerLideresDelArea($solicitud);

        $notificaciones = [];

        foreach ($lideres as $lider) {
            // Crear la notificación
            $notificacion = Notificacion::create([
                'user_id' => $lider->id,
                'tipo' => 'solicitud_epp',
                'titulo' => 'Nueva Solicitud de EPP',
                'mensaje' => "Se ha realizado una nueva solicitud de Elementos de Protección Personal en el programa: {$solicitud->programa->nombre}",
                'solicitud_id' => $solicitud->id,
                'usuario_accion_id' => $usuarioAccion->id,
                'datos_adicionales' => [
                    'programa' => $solicitud->programa->nombre,
                    'ficha' => $solicitud->ficha->codigo ?? 'N/A',
                    'usuario_solicitante' => $usuarioAccion->name,
                    'cantidad_elementos' => $solicitud->elementos()->count(),
                ],
            ]);

            $notificaciones[] = $notificacion;

            // Enviar correo de forma asíncrona
            $this->enviarCorreoNotificacion($notificacion, $lider);
        }

        return $notificaciones[0] ?? null;
    }

    /**
     * Crear una notificación de pedido aprobado
     *
     * @param Pedido $pedido
     * @param User $usuarioAccion
     * @return Notificacion
     */
    public function crearNotificacionPedidoAprobado(Pedido $pedido, User $usuarioAccion): Notificacion
    {
        // Obtener los líderes del área
        $lideres = $this->obtenerLideresDelArea($pedido);

        $notificaciones = [];

        foreach ($lideres as $lider) {
            $notificacion = Notificacion::create([
                'user_id' => $lider->id,
                'tipo' => 'pedido_aprobado',
                'titulo' => 'Pedido de EPP Aprobado',
                'mensaje' => "El pedido de Elementos de Protección Personal ha sido aprobado.",
                'pedido_id' => $pedido->id,
                'usuario_accion_id' => $usuarioAccion->id,
                'datos_adicionales' => [
                    'numero_pedido' => $pedido->numero_pedido ?? $pedido->id,
                    'cantidad_elementos' => $pedido->elementos()->count(),
                    'aprobado_por' => $usuarioAccion->name,
                ],
            ]);

            $notificaciones[] = $notificacion;
            $this->enviarCorreoNotificacion($notificacion, $lider);
        }

        return $notificaciones[0] ?? null;
    }

    /**
     * Crear una notificación de pedido rechazado
     *
     * @param Pedido $pedido
     * @param User $usuarioAccion
     * @param string $razon
     * @return Notificacion
     */
    public function crearNotificacionPedidoRechazado(Pedido $pedido, User $usuarioAccion, string $razon = ''): Notificacion
    {
        $lideres = $this->obtenerLideresDelArea($pedido);

        $notificaciones = [];

        foreach ($lideres as $lider) {
            $notificacion = Notificacion::create([
                'user_id' => $lider->id,
                'tipo' => 'pedido_rechazado',
                'titulo' => 'Pedido de EPP Rechazado',
                'mensaje' => "El pedido de Elementos de Protección Personal ha sido rechazado. Razón: {$razon}",
                'pedido_id' => $pedido->id,
                'usuario_accion_id' => $usuarioAccion->id,
                'datos_adicionales' => [
                    'numero_pedido' => $pedido->numero_pedido ?? $pedido->id,
                    'razon_rechazo' => $razon,
                    'rechazado_por' => $usuarioAccion->name,
                ],
            ]);

            $notificaciones[] = $notificacion;
            $this->enviarCorreoNotificacion($notificacion, $lider);
        }

        return $notificaciones[0] ?? null;
    }

    /**
     * Obtener los líderes del área correspondiente
     *
     * @param mixed $model (Solicitud o Pedido)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function obtenerLideresDelArea($model)
    {
        // Obtener el área según el tipo de modelo
        if ($model instanceof Solicitud) {
            $area = $model->programa->area ?? null;
        } elseif ($model instanceof Pedido) {
            // Obtener el área del primer elemento del pedido
            $area = $model->elementos()->first()?->area ?? null;
        } else {
            return collect();
        }

        if (!$area) {
            return collect();
        }

        // Obtener los usuarios con rol de líder en esa área
        return User::whereHas('roles', function ($query) {
            $query->where('nombre', 'lider');
        })
        ->whereHas('areas', function ($query) use ($area) {
            $query->where('areas.id', $area->id);
        })
        ->get();
    }

    /**
     * Enviar correo de notificación
     *
     * @param Notificacion $notificacion
     * @param User $usuario
     * @return void
     */
    private function enviarCorreoNotificacion(Notificacion $notificacion, User $usuario): void
    {
        try {
            Mail::to($usuario->email)->queue(new NotificacionSolicitudEPP($notificacion));

            // Marcar como enviado
            $notificacion->marcarCorreoEnviado();

            Log::info("Correo de notificación enviado a {$usuario->email}", [
                'notificacion_id' => $notificacion->id,
                'usuario_id' => $usuario->id,
            ]);
        } catch (\Exception $e) {
            Log::error("Error al enviar correo de notificación", [
                'notificacion_id' => $notificacion->id,
                'usuario_id' => $usuario->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Obtener notificaciones no leídas de un usuario
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerNotificacionesNoLeidas(int $userId)
    {
        return Notificacion::where('user_id', $userId)
            ->where('leida', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Obtener el conteo de notificaciones no leídas
     *
     * @param int $userId
     * @return int
     */
    public function contarNotificacionesNoLeidas(int $userId): int
    {
        return Notificacion::where('user_id', $userId)
            ->where('leida', false)
            ->count();
    }

    /**
     * Marcar todas las notificaciones como leídas
     *
     * @param int $userId
     * @return void
     */
    public function marcarTodasComoLeidas(int $userId): void
    {
        Notificacion::where('user_id', $userId)
            ->where('leida', false)
            ->update([
                'leida' => true,
                'fecha_lectura' => now(),
            ]);
    }

    /**
     * Obtener el historial de notificaciones
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerHistorial(int $userId, int $limit = 50)
    {
        return Notificacion::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
