<?php

namespace App\Console;

use App\Mail\AlertasPruebaAES;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            $Vehicles = DB::table('tb_principal')
                        ->select('tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.Fleet','tb_vehicles.Area','tb_vehicles.odo_actual','tb_mtto_history.kms_goal', 'tb_mtto_history.mtto_count','tb_mtto_history.correo','tb_mtto_history.correo_supervisor','tb_principal.quedan')
                        ->join('tb_vehicles','tb_principal.FK_idVehicle','=','tb_vehicles.id')
                        ->join('tb_mtto_history','tb_principal.FK_idMtto','=','tb_mtto_history.id')
                        ->where('tb_vehicles.estado','=',1)
                        ->where('tb_principal.quedan','<',480)
                        ->get();
            foreach ($Vehicles as $item)
            {
                if($item->quedan > 300)
                {
                    Mail::to('ulises.lopez@grupodisatel.com')->send(new AlertasPruebaAES());
                }
                else
                {
                    Mail::to('sistemas.sv@grupodisatel.com')->send(new AlertasPruebaAES());
                }
            }
        })->twiceDaily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
