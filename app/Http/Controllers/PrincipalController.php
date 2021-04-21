<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Vehiculo;
use App\Mantenimiento;
use App\Principal;
use App\Mail\AlertasPruebaAES;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PrincipalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        /**
         * Desplegar el listado de talleres registrados en el sistema con paginacion
         * Se pueden hacer busquedas de datos segun el criterio que el usuario elija.
         * Se almacena en el historial.
         */

        if(!$request->ajax()) return redirect('/');

        //Mail::to('ulises.lopez@grupodisatel.com')->send(new AlertasPruebaAES());

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $desde = $request->desde;
        $hasta = $request->hasta;
        $select_taller = $request->select_taller;
        $select_tipomanto = $request->select_tipomanto;

        if($buscar == null && $desde == null && $hasta == null && $select_taller == null && $select_tipomanto == null){

            $vehicles = Vehiculo::where('estado', true)->get();
            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo',
                                            'mantenimiento',
                                            'mantenimiento.tipomanto',
                                            'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar != null && $desde == null && $hasta == null && $select_taller == null && $select_tipomanto == null){

            $vehicles = Vehiculo::where($criterio, 'like', '%' . $buscar . '%')->where('estado', true)->get();
            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar == null && $desde != null && $hasta != null && $select_taller == null && $select_tipomanto == null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->whereBetween('tb_mtto_history.date', [$desde, $hasta])
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar == null && $desde == null && $hasta == null && $select_taller != null && $select_tipomanto == null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->join('tb_talleres', 'tb_talleres.id', '=', 'tb_mtto_history.FK_taller')
                                ->where('tb_talleres.id', $select_taller)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);
        }elseif($buscar == null && $desde == null && $hasta == null && $select_taller == null && $select_tipomanto != null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->join('tb_tipo_mttos', 'tb_tipo_mttos.id', '=', 'tb_mtto_history.FK_tipoMtto')
                                ->where('tb_tipo_mttos.id', $select_tipomanto)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar != null && $desde != null && $hasta != null && $select_taller == null && $select_tipomanto == null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->whereBetween('tb_mtto_history.date', [$desde, $hasta])
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar != null && $desde == null && $hasta == null && $select_taller != null && $select_tipomanto == null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->where('tb_talleres.id', $select_taller)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar != null && $desde == null && $hasta == null && $select_taller == null && $select_tipomanto != null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->where('tb_tipo_mttos.id', $select_tipomanto)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar == null && $desde != null && $hasta != null && $select_taller != null && $select_tipomanto == null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->whereBetween('tb_mtto_history.date', [$desde, $hasta])
                                ->where('tb_talleres.id', $select_taller)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar == null && $desde != null && $hasta != null && $select_taller == null && $select_tipomanto != null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->whereBetween('tb_mtto_history.date', [$desde, $hasta])
                                ->where('tb_tipo_mttos.id', $select_tipomanto)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar == null && $desde == null && $hasta == null && $select_taller != null && $select_tipomanto != null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where('tb_talleres.id', $select_taller)
                                ->where('tb_tipo_mttos.id', $select_tipomanto)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar != null && $desde != null && $hasta != null && $select_taller != null && $select_tipomanto == null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->whereBetween('tb_mtto_history.date', [$desde, $hasta])
                                ->where('tb_talleres.id', $select_taller)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar != null && $desde != null && $hasta != null && $select_taller == null && $select_tipomanto != null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->whereBetween('tb_mtto_history.date', [$desde, $hasta])
                                ->where('tb_tipo_mttos.id', $select_tipomanto)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }elseif($buscar == null && $desde != null && $hasta != null && $select_taller != null && $select_tipomanto != null){

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->whereBetween('tb_mtto_history.date', [$desde, $hasta])
                                ->where('tb_talleres.id', $select_taller)
                                ->where('tb_tipo_mttos.id', $select_tipomanto)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }else{

            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->whereBetween('tb_mtto_history.date', [$desde, $hasta])
                                ->where('tb_talleres.id', $select_taller)
                                ->where('tb_tipo_mttos.id', $select_tipomanto)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->where('FK_idMtto', '!=', null)
                                    ->orderBy('quedan', 'asc')
                                    ->paginate(50);

        }

        return [

            'pagination' => [
                'total'         => $principales->total(),
                'current_page'  => $principales->currentPage(),
                'per_page'      => $principales->perPage(),
                'last_page'     => $principales->lastPage(),
                'from'          => $principales->firstItem(),
                'to'            => $principales->lastItem(),
            ],

            'principales' => $principales

        ];
    }

    public function alertas()
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

