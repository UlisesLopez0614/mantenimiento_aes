<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tipomanto;

class TipomantoController extends Controller
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
            $tipomantos = Tipomanto::orderBy('nombre', 'asc')->paginate(5);
        }else{
            $tipomantos = Tipomanto::where($criterio, 'like', '%' . $buscar . '%')->orderBy('nombre', 'asc')->paginate(5);
        }

        return [
            
            'pagination' => [
                'total'         => $tipomantos->total(),
                'current_page'  => $tipomantos->currentPage(),
                'per_page'      => $tipomantos->perPage(),
                'last_page'     => $tipomantos->lastPage(),
                'from'          => $tipomantos->firstItem(),
                'to'            => $tipomantos->lastItem(),
            ],

            'tipomantos' => $tipomantos

        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Guardar en la BD del sistema el nuevo registro de taller.
         * Se almacena en el historial.
         */

        if(!$request->ajax()) return redirect('/');

        $tipomanto = new Tipomanto();

            $tipomanto->nombre = $request->nombre;
            $tipomanto->cantidad = $request->cantidad;
            $tipomanto->umedida = $request->umedida;
            $tipomanto->porcentajealerta = $request->porcentajealerta;

        $tipomanto->save();
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /**
         * Actualizar en la BD del sistema el registro seleccionado.
         * Se almacena en el historial.
         */

        if(!$request->ajax()) return redirect('/');

        $tipomanto = Tipomanto::findOrFail($request->id);

            $tipomanto->nombre = $request->nombre;
            $tipomanto->cantidad = $request->cantidad;
            $tipomanto->umedida = $request->umedida;
            $tipomanto->porcentajealerta = $request->porcentajealerta;

        $tipomanto->save();

    }

    public function desactivar(Request $request)
    {
        /**
         * Cambiar el estado de un taller a Desactivado.
         * Se almacena en el historial.
         */

        if(!$request->ajax()) return redirect('/');

        $tipomanto = Tipomanto::findOrFail($request->id);

            $tipomanto->condicion = false;

        $tipomanto->save();

    }

    public function activar(Request $request)
    {
        /**
         * Cambiar el estado de un taller a Activado.
         * Se almacena en el historial.
         */

        if(!$request->ajax()) return redirect('/');

        $tipomanto = Tipomanto::findOrFail($request->id);

            $tipomanto->condicion = true;

        $tipomanto->save();

    }

    public function selectTipomanto(Request $request)
    {
        /**
         * Devuelve los talleres registrados con condicion Activo.
         */

        $tipomantos = Tipomanto::where('condicion', true)->select('id', 'nombre')->orderBy('nombre', 'asc')->get();

        return ['tipomantos' => $tipomantos];
        
    }

}
