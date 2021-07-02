<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Mantenimiento;
use App\Principal;
use App\Vehiculo;
use App\HistorialVehiculo;
use Illuminate\Support\Facades\Log;

class MantenimientoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /**
         * Desplegar el listado de talleres registrados en el sistema con paginacion
         * Se pueden hacer busquedas de datos segun el criterio que el usuario elija.
         * Se almacena en el historial.
         */

        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $mantenimientos = Mantenimiento::with('tipomanto', 'taller')->where('FK_idVehicle', $request->vehiculo)->get();
            //dd($mantenimientos);
        } else {
            //$talleres = Taller::where($criterio, 'like', '%' . $buscar . '%')->orderBy('nombre', 'asc')->paginate(5);
        }

        return [

            'mantenimientos' => $mantenimientos

        ];
    }

    public function store(Request $request)
    {
        /**
         * Guardar en la BD del sistema el nuevo registro de taller.
         * Se almacena en el historial.
         */

        if (!$request->ajax()) return redirect('/');

        $kms_goal = $request->odohwinicial + $request->cantidad;

        $ulto_manto = Principal::select('tb_principal.*')
            ->where('tb_principal.FK_idVehicle', $request->vehiculo)
            ->first();

        $mantenimiento = Mantenimiento::select('tb_mtto_history.*', 'tb_tipo_mttos.cantidad')
            ->join('tb_tipo_mttos', 'tb_tipo_mttos.id', '=', 'tb_mtto_history.FK_tipoMtto')
            ->where('tb_mtto_history.id', $ulto_manto->FK_idMtto)
            ->first();

        $quedan = $mantenimiento->kms_goal - $request->odohwinicial;

        $estado_alerta = '';

        if ($quedan > (($mantenimiento->cantidad * $mantenimiento->porcentaje_alerta_por_vencerse) / 100)) {

            $estado_alerta = 'VERDE';

        } elseif ($quedan <= (($mantenimiento->cantidad * $mantenimiento->porcentaje_alerta_por_vencerse) / 100) && $quedan > 0) {

            $estado_alerta = 'NARANJA';

        } else {

            $estado_alerta = 'ROJA';
        }

        //Se crea un nuevo record de mantenimiento
        $VH = Vehiculo::findorFail($request->vehiculo);
        $mantenimiento = new Mantenimiento();
        $mantenimiento->FK_idVehicle = $request->vehiculo;
        $mantenimiento->FK_taller = $request->taller;
        ($VH->type == 'PESADO') ? $mantenimiento->FK_tipoMtto = 2 : $mantenimiento->FK_tipoMtto = 1;
        $mantenimiento->alerta_naranja = $request->alertanaranja;
        $mantenimiento->alerta_roja = $request->alertaroja;
        $mantenimiento->alerta_prox_vencer = $request->alertaproxima;
        $mantenimiento->recordatorio_diario_vencido = $request->recordatorioven;
        $mantenimiento->recordatorio_diario_por_vencerse = $request->recordatorioporven;
        $mantenimiento->porcentaje_alerta_por_vencerse = $request->porcentajealerta;
        $mantenimiento->estado_alerta = $estado_alerta;
        $mantenimiento->save();
        //----------------
        $ulto_manto->FK_idMtto = $mantenimiento->id;
        $ulto_manto->quedan = $request->cantidad;
        $Vehicle = Vehiculo::findorFail($request->vehiculo);
        ($Vehicle->type == 'PESADO') ? $ulto_manto->counter = 1 :
            (($ulto_manto->counter == 6) ? $ulto_manto->counter = 1 : $ulto_manto->counter = $ulto_manto->counter + 1);
        $ulto_manto->save();
    }

    public function update(Request $request)
    {
        /**
         * Guardar en la BD del sistema el nuevo registro de taller.
         * Se almacena en el historial.
         */

        if (!$request->ajax()) return redirect('/');
        try {
            $mantenimiento = Mantenimiento::findorFail($request->slug);
            $VH = Vehiculo::findOrFail($mantenimiento->FK_idVehicle);
            $mantenimiento->correo = $request->correoalerta;
            $mantenimiento->correo_supervisor = $request->correoalertagrave;
            $mantenimiento->costo = $request->costo;
            $mantenimiento->save();
        } catch (Illuminate\Database\QueryException $ex) {
            Log::warning($ex->getMessage());
            Log::info("Request : " + $request);
        }
    }
}
