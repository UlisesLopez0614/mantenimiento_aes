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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        $Records = DB::table('tb_principal')
            ->select('tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.Fleet','tb_vehicles.Area','tb_vehicles.odo_actual','tb_mtto_history.kms_goal', 'tb_mtto_history.mtto_count','tb_mtto_history.correo','tb_mtto_history.correo_supervisor','tb_principal.quedan')
            ->join('tb_vehicles','tb_principal.FK_idVehicle','=','tb_vehicles.id')
            ->join('tb_mtto_history','tb_principal.FK_idMtto','=','tb_mtto_history.id')
            ->where('tb_vehicles.estado','=',1)
            ->where('tb_principal.quedan','<',500)
            ->get();//Obtenemos los registros
        $correos = collect();//Creamos un contenedor para los correos normales
        $correos_sups = collect();//Creamos un contenedor para los correos de los superiores
        foreach ($Records as $item)
        {
            $data = collect(explode(";", $item->correo));
            $sup_data = collect(explode(";", $item->correo_supervisor));
            //Obtenemos todos los correos de los registros
            foreach($data as $key => $value)
            {
                //Validamos que lo que ingresaron sea un correo valido
                try{
                    $validator = Validator::make(['email' => $value], [
                        'email' => 'email|required',
                    ]);
                    if(!$validator->fails()){$correos->push(Str::lower(trim($value)));}
                }catch (\Exception $e){
                    Log::error("Invalid Email for element: ".$item);
                }
            }

            //Obtenemos todos los correos de los registros
            foreach($sup_data as $key => $value)
            {
                //Validamos que lo que ingresaron sea un correo valido
                try{
                    $validator = Validator::make(['email' => $value], [
                        'email' => 'email|required',
                    ]);
                    if(!$validator->fails()){$correos_sups->push(Str::lower(trim($value)));}
                }catch (\Exception $e){
                    Log::error("Invalid Email for element: ".$item);
                }
            }
            $correos = $correos->unique()->sort();//Se eliminan los duplicados
            $correos_sups = $correos_sups->unique()->sort();//Se eliminan los duplicados
        }
        //Envio de correos a cada usuario normal
        foreach ($correos as $key => $value){
            $Mtos = DB::table('tb_principal')
                ->select('tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.Fleet','tb_vehicles.Area','tb_vehicles.odo_actual','tb_mtto_history.kms_goal', 'tb_mtto_history.mtto_count','tb_mtto_history.correo','tb_mtto_history.correo_supervisor','tb_principal.quedan')
                ->join('tb_vehicles','tb_principal.FK_idVehicle','=','tb_vehicles.id')
                ->join('tb_mtto_history','tb_principal.FK_idMtto','=','tb_mtto_history.id')
                ->where('tb_vehicles.estado','=',1)
                ->where('tb_principal.quedan','<',500)
                ->where('tb_principal.quedan','>',300)
                ->where('tb_mtto_history.correo','LIKE','%'.$value.'%')
                ->get();
            $Data = collect();
            foreach($Mtos as $item){
                $Data->push(['Name'=>$item->Name.'-'.$item->Plate,'KM'=>$item->quedan]);
            }
            Mail::to(trim($value))->queue(new AlertasPruebaAES($Data));
        }
        //Envio de correos a superiores
        foreach ($correos_sups as $key => $value){
            $Mtos = DB::table('tb_principal')
                ->select('tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.Fleet','tb_vehicles.Area','tb_vehicles.odo_actual','tb_mtto_history.kms_goal', 'tb_mtto_history.mtto_count','tb_mtto_history.correo','tb_mtto_history.correo_supervisor','tb_principal.quedan')
                ->join('tb_vehicles','tb_principal.FK_idVehicle','=','tb_vehicles.id')
                ->join('tb_mtto_history','tb_principal.FK_idMtto','=','tb_mtto_history.id')
                ->where('tb_vehicles.estado','=',1)
                ->where('tb_principal.quedan','<',300)
                ->where('tb_mtto_history.correo_supervisor','LIKE','%'.$value.'%')
                ->get();
            $Data = collect();
            foreach($Mtos as $item){
                $Data->push(['Name'=>$item->Name.'-'.$item->Plate,'KM'=>$item->quedan]);
            }
            Mail::to(trim($value))->queue(new AlertasPruebaAES($Data));
        }
    }
}
//Logica para correos Individuales
/*
            $VeH = $item->Name."-".$item->Plate." / ".$item->Fleet." ".$item->Area;
            $correos = collect(explode(";", $item->correo));
            $correo_sup = collect(explode(";", $item->correo_supervisor));
            //Obtenemos el listado de correos
            if($item->quedan > 300)
            {
                foreach($correos as $key => $value)
                {
                    try{
                        Mail::to(trim($value))->queue(new AlertasPruebaAES($VeH,$item->quedan));
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
                        Mail::to(trim($value))->queue(new AlertasPruebaAES($VeH,$item->quedan));
                    }catch (\Exception $e){
                        Log::channel('alerts')->error("Invalid Email ".$value." for element: ".$item);
                    }
                }
            }*/
