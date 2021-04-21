<?php

namespace App\Console\Commands;

use App\Mail\AlertasPruebaAES;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de Alertas de Vehiculos con Mantenimiento';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $Vehicles = DB::table('tb_principal')
            ->select('tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.Fleet','tb_vehicles.Area','tb_vehicles.odo_actual','tb_mtto_history.kms_goal', 'tb_mtto_history.mtto_count','tb_mtto_history.correo','tb_mtto_history.correo_supervisor','tb_principal.quedan')
            ->join('tb_vehicles','tb_principal.FK_idVehicle','=','tb_vehicles.id')
            ->join('tb_mtto_history','tb_principal.FK_idMtto','=','tb_mtto_history.id')
            ->where('tb_vehicles.estado','=',1)
            ->where('tb_principal.quedan','<',480)
            ->get();
        foreach ($Vehicles as $item)
        {
            $VeH = $item->Name."-".$item->Plate." / ".$item->Fleet." ".$item->Area;
            if($item->quedan > 300)
            {
                $correos = collect(explode(";", $item->correo));
                foreach($correos as $key => $value)
                {
                    Mail::to($value)->queue(new AlertasPruebaAES($VeH,$item->quedan));
                }
            }
            else
            {
                $correo_sup = explode(";", $item->correo_supervisor);
                foreach($correo_sup as $key => $value)
                {
                    Mail::to($value)->queue(new AlertasPruebaAES($VeH,$item->quedan));
                }
            }
        }
    }
}
