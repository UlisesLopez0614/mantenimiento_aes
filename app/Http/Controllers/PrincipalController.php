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

        if($buscar == null ){
            $principales = Principal::with('vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller')->paginate(15);
            /*$principales = Principal::join('tb_vehicles', 'tb_vehicles.id', '=', 'tb_principal.FK_idVehicle')
                                    ->rightjoin('tb_mtto_history', 'tb_mtto_history.id', '=', 'tb_principal.FK_idMtto')
                                    ->join('tb_tipo_mttos', 'tb_tipo_mttos.id', '=', 'tb_mtto_history.FK_tipoMtto')
                                    ->join('tb_talleres', 'tb_talleres.id', '=', 'tb_mtto_history.FK_taller')
                                    ->paginate(15);*/
        }elseif($buscar != null){
            //dd($buscar);
            $vehicles = Vehiculo::where($criterio, 'like', '%' . $buscar . '%')->get();
            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

            $principales = Principal::with([
                                        'vehiculo', 
                                        'mantenimiento', 
                                        'mantenimiento.tipomanto', 
                                        'mantenimiento.taller'
                                    ])
                                    ->whereIn('FK_idVehicle', $arreglo_vehiculos)
                                    ->paginate(15);
                                    //dd($principales);
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
