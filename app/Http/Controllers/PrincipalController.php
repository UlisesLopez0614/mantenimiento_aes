<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Vehiculo;
use App\Mantenimiento;
use App\Principal;

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

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $criterio2 = $request->criterio2;
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

            $principales = Principal::with('vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller')->whereIn('FK_idVehicle', $arreglo_vehiculos)->paginate(15);

        }elseif($buscar != null && $desde == null && $hasta == null && $select_taller == null && $select_tipomanto == null){
            
            $vehicles = Vehiculo::where($criterio, 'like', '%' . $buscar . '%')->where('estado', true)->get();
            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->paginate(15);
                                    
        }elseif($buscar == null && $desde != null && $hasta != null && $select_taller == null && $select_tipomanto == null){
            
            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->whereBetween($criterio2, [$desde, $hasta])
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->paginate(15);
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
                                    ->paginate(15);
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
                                    ->paginate(15);
        }elseif($buscar != null && $desde != null && $hasta != null && $select_taller == null && $select_tipomanto == null){
            
            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->whereBetween($criterio2, [$desde, $hasta])
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->paginate(15);
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
                                    ->paginate(15);
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
                                    ->paginate(15);
        }elseif($buscar == null && $desde != null && $hasta != null && $select_taller != null && $select_tipomanto == null){
            
            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->whereBetween($criterio2, [$desde, $hasta])
                                ->where('tb_talleres.id', $select_taller)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->paginate(15);
        }elseif($buscar == null && $desde != null && $hasta != null && $select_taller == null && $select_tipomanto != null){
            
            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->whereBetween($criterio2, [$desde, $hasta])
                                ->where('tb_tipo_mttos.id', $select_tipomanto)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->paginate(15);
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
                                    ->paginate(15);
        }elseif($buscar != null && $desde != null && $hasta != null && $select_taller != null && $select_tipomanto == null){
            
            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->whereBetween($criterio2, [$desde, $hasta])
                                ->where('tb_talleres.id', $select_taller)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->paginate(15);
        }elseif($buscar != null && $desde != null && $hasta != null && $select_taller == null && $select_tipomanto != null){
            
            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->whereBetween($criterio2, [$desde, $hasta])
                                ->where('tb_tipo_mttos.id', $select_tipomanto)
                                ->where('estado', true)
                                ->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with(['vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller'])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->paginate(15);
        }elseif($buscar == null && $desde != null && $hasta != null && $select_taller != null && $select_tipomanto != null){
            
            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->whereBetween($criterio2, [$desde, $hasta])
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
                                    ->paginate(15);
        }else{
            
            $vehicles = Vehiculo::select('tb_vehicles.id')
                                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'tb_vehicles.id')
                                ->where($criterio, 'like', '%' . $buscar . '%')
                                ->whereBetween($criterio2, [$desde, $hasta])
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
                                    ->paginate(15);
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
}
