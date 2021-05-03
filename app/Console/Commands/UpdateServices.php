<?php

namespace App\Console\Commands;

use App\HistorialVehiculo;
use App\Mantenimiento;
use App\Principal;
use App\Vehiculo;
use Carbon\Carbon;
use Faker\Provider\Base;
use Faker\Provider\DateTime;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updatehistory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Servicio de Actualizacion de Registros de Historial de Flota';

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
        Log::channel('SummaryUpdates')->info("Iniciando Registros el dia  : ".now()->formatLocalized('%A').", ".now()->formatLocalized('%d, %B %Y, a las %H:%M  '));
        foreach($Vehicles as $VH)
        {
            try
            {
                $response = Http::get('http://avlaes.disatelgps.com/ws/?api=VehicleSummary&sitekey=avlaes&usr=admin&pwd=aes&veh='.$VH->idAVL.'&dat='.now()->format('Y-m-d'))->json();
                dd('http://avlaes.disatelgps.com/ws/?api=VehicleSummary&sitekey=avlaes&usr=admin&pwd=aes&veh=863286020928165&dat='.now()->format('Y-m-d'));
                if($response[0]['Date'] == '-')
                {
                    Log::channel('SummaryUpdates')->warning("No hay registros el dia : ".now()->format('Y-m-d')." para el vehiculo con placas : ".$VH->Plate);
                }
                else
                {
                    $VH_Record = new HistorialVehiculo();
                    $VH_Record->FK_idVehicle = $VH->id;
                    $VH_Record->Date = now()->format('Y-m-d');
                    $VH_Record->Time = now()->format('H:m:s');
                    $VH_Record->Positions = $response[0]['Positions'];
                    $VH_Record->Distance = $response[0]['Distance'];
                    $VH_Record->AvgSpeed = $response[0]['AvgSpeed'];
                    $VH_Record->MaxSpeed = $response[0]['MaxSpeed'];
                    $VH_Record->FuelAvg = $response[0]['FuelAvg'];
                    $VH_Record->MovTime = $response[0]['MovTime'];
                    $VH_Record->Stops = $response[0]['Stops'];
                    $VH_Record->StopTime = $response[0]['StopTime'];
                    $VH_Record->StopTimeOn = $response[0]['StopTimeOn'];
                    $VH_Record->GeoEvents = $response[0]['GeoEvents'];
                    $VH_Record->save();

                    $VH->kms_inicial = $VH->kms_inicial + $response[0]['Distance'];
                    $VH->save();

                    $Principal_Table = Principal::where('FK_idVehicle','=',$VH->id)->first();
                    if($Principal_Table->FK_idMtto){
                        Log::channel('SummaryUpdates')->info('Actualizando Registros para el Vehiculo IDAVL : '.$VH->idAVL. ' y placas : '.$VH->Plate);
                        Log::channel('SummaryUpdates')->info('Distancia Restante  :'.$Principal_Table->quedan.' KMS.');
                        $Mantenimiento_Record = Mantenimiento::findorFail($Principal_Table->FK_idMtto);
                        $Remaining_KMS = round($Mantenimiento_Record->kms_goal - $VH->kms_inicial,2);
                        Log::channel('SummaryUpdates')->info('Nueva Distancia Restante :'.$Remaining_KMS.' KMS.');
                        $Principal_Table->quedan = $Remaining_KMS;
                        $Principal_Table->save();
                    }
                }
            }
            catch (\Exception $e){
                Log::channel('SummaryUpdates')->error("ERROR CRITICO : ".$e . " idAVL : ".$VH->idAVL);
            }
        }
        Log::channel('SummaryUpdates')->info("Fin de los Registros. Fecha y Hora de Finalizacion  : ".now()->formatLocalized('%A').", ".now()->formatLocalized('%d, %B %Y, a las %H:%M  '));
        return 'Actualizacion Completada';
    }
}
