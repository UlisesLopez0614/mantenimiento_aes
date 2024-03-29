<?php

namespace App\Console\Commands;

use App\Mantenimiento;
use App\Principal;
use App\Vehiculo;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateODO extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdateODO';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando de Actualizacion Manual de Odometros';

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
        Carbon::setLocale('es');
        setlocale(LC_ALL, 'es');
        $Vehicles = Vehiculo::all();
        $initial_date = new DateTime('2021-05-06');
        $end_date = now();
        /* Mini Servicio de Actualizacion de Placas y idAVL en base a viejos registros
        $Old_Data = DB::table('ex')->get();
        foreach ($Old_Data as $ex ){
            $VH = Vehiculo::where('Name','=',$ex->Name)->first();
            if($VH != null ){
                $VH->idAVL = $ex->idAVL;
                $VH->Plate = $ex->Plate;
                $VH->Fleet = $ex->Fleet;
                $VH->save();
            }
        }
        dd("Done");*/
        $counter = 0;
        Log::channel('ODO')->info('Actualizando Registros para Vehiculos  : '.now());
        foreach($Vehicles as $VH)
        {
            $Pri = Principal::where('FK_idVehicle','=',$VH->id)->first();
            $Man = Mantenimiento::findorFail($Pri->FK_idMtto);
            $Pri->quedan = $Man->kms_goal - $VH->kms_inicial;
            $Pri->save();
            $VH_distance = 0;
            while($initial_date <=$end_date)
            {
                try
                {
                    //$response = Http::get('http://avlaes.disatelgps.com/ws/?api=VehicleHistory&sitekey=avlaes&usr=admin&pwd=aes&veh='.$VH->idAVL.'&dat='.$initial_date->format('Y-m-d'))->json();
                    $response = Http::get('http://avlaes.disatelgps.com/ws/?api=VehicleSummary&sitekey=avlaes&usr=admin&pwd=aes&veh=860147041658269&dat='.$initial_date->format('Y-m-d'))->json();
                    //Log::channel('ODO')->info('Actualizando Registros para el Vehiculo IDAVL : '.$VH->idAVL. ' y placas : '.$VH->Plate);
                    if($response == []  ||$response[0]['Distance'] == 0)
                    {
                        //Log::channel('ODO')->alert("No hay registros para este Equipo: ".$VH->idAVL.", con placas : ".$VH->Plate.', el dia : '.$initial_date->format('Y-m-d'));
                    }
                    else
                    {
                        //dd('http://avlaes.disatelgps.com/ws/?api=VehicleSummary&sitekey=avlaes&usr=admin&pwd=aes&veh='.$VH->idAVL.'&dat='.now()->format('Y-m-d'));
                        $VH_distance += $response[0]['Distance'];
                    }
                }
                catch (\Exception $e){
                    Log::channel('ODO')->error("ERROR CRITICO : ".$e . " idAVL : ".$VH->idAVL);
                }
                Log::channel('ODO')->info('Distancia Recorrida por '.$VH->Name.'-'.$VH->Plate.', el dia : '.$initial_date->format('Y-m-d').' fue de : '.$response[0]['Distance'].' KMS .');
                $initial_date->modify('+1 day');
            }
            //dd($VH_distance);
            $VH->kms_inicial += $VH_distance;
            $VH->save();
        }
        //Log::channel('ODO')->info("Fin de la Actualizacion. Fecha y Hora de Finalizacion  : ".now()->formatLocalized('%A').", ".now()->formatLocalized('%d, %B %Y, a las %H:%M  '));
        //dd($counter);
        //Log::channel('ODO')->info("Dia de Actualizacion de Odometros  : ".now()->formatLocalized('%A').", ".now()->formatLocalized('%d, %B %Y, a las %H:%M  '));

        return 'Odometros Actualizacidos :D';
    }
}
