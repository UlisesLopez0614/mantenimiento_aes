<?php

namespace App\Console\Commands;

use App\Mantenimiento;
use App\Principal;
use App\Vehiculo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateVehiclesInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UPDATE:VEHICLES';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Servicio de Actualizacion de Informacion de los vehiculos, actualiza datos generales del vehiculo, con excepcion de los odometros';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try{
            $Vehicles = Vehiculo::all();
            $response = collect(Http::get('http://avlaes.disatelgps.com/ws/?api=Vehicles&sitekey=avlaes&usr=admin&pwd=aes')->json());
            //Log::channel('ODO')->info('Actualizando Registros para Vehiculos  : ' . now());
            foreach ($response as $VH)
            {
                if($VH != 'EQ A ELIMINAR')
                {
                    $Vehicle = $Vehicles->where('Name','=',$VH['Name'])->first();
                    $Vehicle->idAVL = $VH['ID'];
                    $Vehicle->Plate = $VH['Plate'];
                    $Fleet_Info = explode(' ',$VH['Fleet']);
                    $Vehicle->Fleet = $Fleet_Info[0];
                    $Vehicle->Area = $Fleet_Info[1];
                    $Vehicle->type = $VH['Description'];
                    $Vehicle->save();
                }
            }
        }catch (\Exception $e){

        }
        return 'Vehiculos Actualizados';
    }
}

