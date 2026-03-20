<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class PedidosAgrupadosAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $pedidos;
    public $area;
    public $instructores;

    public function __construct(Collection $pedidos, $area, $instructores)
    {
        // ⚡ TRANSFORMAR datos (esto es clave)
        $this->pedidos = $pedidos->map(function ($pedido) {
            return [
                'id' => $pedido->id,
                'usuario' => $pedido->usuario->nombre_completo ?? '',
                'area' => $pedido->usuario->area->nombre ?? '',
                'programa' => $pedido->ficha->programa->nombre ?? '',
                'fecha' => $pedido->created_at->format('d/m/Y'),
            ];
        });

        $this->area = $area;
        $this->instructores = $instructores;
    }

    public function build()
{
    return $this->subject('📦 Consolidado de pedidos - ' . $this->area)
        ->view('emails.pedido_admin')
        ->with([
            'pedidos' => $this->pedidos,
            'area' => $this->area,
            'instructores' => $this->instructores,
        ]);
}
}
