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

        if($buscar == ''){
            $principales = Principal::with('vehiculo', 'mantenimiento', 'mantenimiento.tipomanto', 'mantenimiento.taller')->paginate(5);
            //dd($principales[41]);
        }else{
            //$talleres = Taller::where($criterio, 'like', '%' . $buscar . '%')->orderBy('nombre', 'asc')->paginate(5);
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
