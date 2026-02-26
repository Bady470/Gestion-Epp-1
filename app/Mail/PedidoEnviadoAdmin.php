<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoEnviadoAdmin extends Mailable
{
    use Queueable, SerializesModels;

    // 👈 CAMBIO: Ahora recibe un array de pedidos
    public $pedidos;
    public $area;

    public function __construct($pedidos, $area)
    {
        // 👈 NUEVO: Asegurar que siempre es un array
        $this->pedidos = is_array($pedidos) ? $pedidos : [$pedidos];
        $this->area = $area;
    }

    public function build()
    {
        return $this->subject('Solicitudes de EPP - ' . $this->area)
                    ->view('emails.pedido_admin');
    }
}
