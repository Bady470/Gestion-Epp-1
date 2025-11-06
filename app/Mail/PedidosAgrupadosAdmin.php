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

    /**
     * Crear una nueva instancia del mensaje.
     */
    public function __construct(Collection $pedidos)
    {
        $this->pedidos = $pedidos;
    }

    /**
     * Construir el mensaje.
     */
    public function build()
    {
        return $this->subject('📦 Pedidos agrupados de EPP enviados por el Líder')
                    ->markdown('emails.pedidos.agrupados')
                    ->with(['pedidos' => $this->pedidos]);
    }
}