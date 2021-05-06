<?php

namespace App\Console\Commands;

use App\Mail\AlertasPruebaAES;
use App\Mantenimiento;
use App\Principal;
use App\Vehiculo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        /*        ---------------------- / Actualizacion Manual Quedan ----------------
        $Principal_Table = Principal::all();
        foreach ($Principal_Table as $P){
            $Mantenimiento_Record = Mantenimiento::findorFail($P->FK_idMtto);
            $VH = Vehiculo::findorFail($Mantenimiento_Record->FK_idVehicle);
            $P->quedan = round($Mantenimiento_Record->kms_goal - $VH->kms_inicial,2);
            $P->save();
        }
        ---------------------- / Actualizacion Manual Quedan ----------------*/
        Log::channel('alerts')->info("Alertas Diarias del dia : ".now());
        $Vehicles = DB::table('tb_principal')
            ->select('tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.Fleet','tb_vehicles.Area','tb_vehicles.odo_actual','tb_mtto_history.kms_goal', 'tb_mtto_history.mtto_count','tb_mtto_history.correo','tb_mtto_history.correo_supervisor','tb_principal.quedan')
            ->join('tb_vehicles','tb_principal.FK_idVehicle','=','tb_vehicles.id')
            ->join('tb_mtto_history','tb_principal.FK_idMtto','=','tb_mtto_history.id')
            ->where('tb_vehicles.estado','=',1)
            ->where('tb_principal.quedan','<',500)
            ->get();
        foreach ($Vehicles as $item)
        {
            $VeH = $item->Name."-".$item->Plate." / ".$item->Fleet." ".$item->Area;
            $correos = collect(explode(";", $item->correo));
            $correo_sup = explode(";", $item->correo_supervisor);
            if($item->quedan > 300)
            {
                foreach($correos as $key => $value)
                {
                    try{
                        Mail::to($value)->queue(new AlertasPruebaAES($VeH,$item->quedan));
                    }catch (\Exception $e){
                        Log::channel('alerts')->error("Invalid Email ".$value." for element: ".$item);
                    }
                }
            }
            else
            {
                foreach($correo_sup as $key => $value)
                {
                    try{
                        Mail::to($value)->queue(new AlertasPruebaAES($VeH,$item->quedan));
                    }catch (\Exception $e){
                        Log::channel('alerts')->error("Invalid Email ".$value." for element: ".$item);
                    }
                }
            }
        }
    }
}
