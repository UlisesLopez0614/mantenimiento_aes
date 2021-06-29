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
        $desde = $request->desde;
        $hasta = $request->hasta;

        $arreglo_vehiculos = [];
        if($desde != null && $hasta != null){

            $vehicles = Vehiculo::select('vehicles.id')
                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'vehicles.id')
                ->join('tb_talleres', 'tb_talleres.id', '=', 'tb_mtto_history.FK_taller')
                ->where('Name', 'LIKE', '%'.$buscar.'%')
                ->Where('estado','<>',0)
                ->whereBetween('tb_mtto_history.date', [$desde, $hasta])
                ->orWhere('tb_talleres.nombre','LIKE', '%'.$buscar.'%')
                ->orWhere('Plate', 'LIKE', '%'.$buscar.'%')
                ->orWhere('Fleet', 'LIKE', '%'.$buscar.'%')
                ->orWhere('Area', 'LIKE', '%'.$buscar.'%')
                ->orWhere('type','=',strtoupper($buscar))
                ->get();
        }
        else{

            $vehicles = Vehiculo::select('vehicles.id')
                ->join('tb_mtto_history', 'tb_mtto_history.FK_idVehicle', '=', 'vehicles.id')
                ->join('tb_talleres', 'tb_talleres.id', '=', 'tb_mtto_history.FK_taller')
                ->where('Name', 'LIKE', '%'.$buscar.'%')
                ->Where('estado','<>',0)
                ->orWhere('tb_talleres.nombre','LIKE', '%'.$buscar.'%')
                ->orWhere('Plate', 'LIKE', '%'.$buscar.'%')
                ->orWhere('Fleet', 'LIKE', '%'.$buscar.'%')
                ->orWhere('Area', 'LIKE', '%'.$buscar.'%')
                ->orWhere('type','=',strtoupper($buscar))
                ->get();
        }
        foreach($vehicles as $item) {$arreglo_vehiculos[] = $item->id;}

        $principales = Principal::with(['vehiculo',
            'mantenimiento',
            'mantenimiento.tipomanto',
            'mantenimiento.taller'])
            ->whereIn('FK_idVehicle', $arreglo_vehiculos)
            ->where('FK_idMtto', '!=', null)
            ->orderBy('quedan', 'asc')
            ->paginate(50);


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

