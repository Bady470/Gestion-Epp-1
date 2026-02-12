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
        $this->pedidos = $pedidos;
        $this->area = $area;
        $this->instructores = $instructores;
    }

    public function build()
    {
        return $this->subject('📦 Pedidos agrupados de la Área: ' . $this->area)
            ->markdown('emails.pedidos.agrupados')
            ->with([
                'pedidos' => $this->pedidos,
                'area' => $this->area,
                'instructores' => $this->instructores,
            ]);
    }
}
    