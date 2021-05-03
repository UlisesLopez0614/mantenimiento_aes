<?php

namespace App\Http\Controllers;

use App\Lubricantes_History;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ControllerForWorkshops extends Controller
{
    public function getListadoMantenimientos(Request $request){
        if(!$request->ajax()) return redirect('/');
        $User = User::findorFail(Auth::id());

        /*$Records = Lubricantes_History::select('id','vehicle_id','FK_taller')
            ->with([
                'vehiculo' => function ($query) {
                return $query->select('Plate', 'type')->get();
            },'taller'])
            ->where('FK_taller',$User->Taller_id)->where('Date_In_Workshop',null)
            ->paginate(50);
        For some fukin reason this sh*t does the select stament for the relationship but doesnt return anything on json
        */

        $Records = Lubricantes_History::select('id','vehicle_id','FK_taller','Date_Out_Fleet')
            ->with(['vehiculo','taller'])
            ->where('FK_taller',$User->Taller_id)->where('Date_In_Workshop',null)
            ->paginate(50);

        return [
            'pagination' => [
                'total'         => $Records->total(),
                'current_page'  => $Records->currentPage(),
                'per_page'      => $Records->perPage(),
                'last_page'     => $Records->lastPage(),
                'from'          => $Records->firstItem(),
                'to'            => $Records->lastItem(),
            ],
            'records' => $Records

        ];
    }

    public function registerMantenimiento(Request $request){
        if(!$request->ajax()) return redirect('/');
        try{
            $mantenimiento = Lubricantes_History::findorFail($request->slug);
            $mantenimiento->Date_In_Workshop = $request->Date_In;
            $mantenimiento->Tipo_Reparacion = $request->Details;
            $mantenimiento->Qty_Qts = $request->Qty;
            $mantenimiento->Qty_Gals = $request->Qty/4;
            $mantenimiento->Date_Out_Workshop = $request->Date_Out;
            $mantenimiento->save();
        }catch(Illuminate\Database\QueryException $ex){
            Log::warning($ex->getMessage());
            Log::info("Request : " + $request);
        }

    }
}
