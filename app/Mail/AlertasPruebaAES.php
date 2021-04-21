<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertasPruebaAES extends Mailable
{
    use Queueable, SerializesModels;

    public $subject= 'Alerta de Mantenimiento Cercano';

    public $VH,$QTY ;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Vehicle,$Qty)
    {
        $this->VH = $Vehicle;
        $this->QTY = $Qty;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('jose.delao@grupodisatel.com')->view('prueba_correo');
    }
}
