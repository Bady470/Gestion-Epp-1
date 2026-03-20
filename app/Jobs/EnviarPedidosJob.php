<?php

namespace App\Jobs;

use App\Models\Pedido;
use App\Models\User;
use App\Models\Notificacion;
use App\Mail\PedidosAgrupadosAdmin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;

class EnviarPedidosJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $user = $this->user;

        $pedidos = Pedido::whereHas('usuario', function ($query) use ($user) {
            $query->where('areas_id', $user->areas_id);
        })
        ->where('estado', 'pendiente')
        ->with(['usuario.area', 'elementos', 'ficha.programa'])
        ->get();

        if ($pedidos->isEmpty()) return;

        $areaNombre = $user->area->nombre ?? 'Área desconocida';
        $instructores = $pedidos->pluck('usuario.nombre_completo')->unique();

        // 📧 correo
        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->send(
            new PedidosAgrupadosAdmin($pedidos, $areaNombre, $instructores)
        );

        // ⚡ update masivo (NO foreach)
        Pedido::whereIn('id', $pedidos->pluck('id'))
            ->update(['estado' => 'enviado']);

        // ⚡ notificaciones
        $admins = User::where('roles_id', 1)->pluck('id');

        foreach ($admins as $adminId) {
            Notificacion::create([
                'user_id' => $adminId,
                'tipo' => 'consolidado_pedidos',
                'titulo' => 'Consolidado de Pedidos Enviado',
                'mensaje' => "Se han enviado {$pedidos->count()} pedidos del área.",
                'usuario_accion_id' => $user->id,
                'leida' => false
            ]);
        }
    }
}
