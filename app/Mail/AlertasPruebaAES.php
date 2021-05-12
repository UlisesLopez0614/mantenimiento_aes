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

    public $VH_Info ;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Vehicle_Info)
    {
        $this->VH_Info = $Vehicle_Info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('sistemas.sv@grupodisatel.com')->view('prueba_correo');
    }
}
