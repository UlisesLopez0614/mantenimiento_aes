<?php

namespace App\Http\Controllers;

use App\Lubricantes_History;

use App\Mantenimiento;
use App\User;
use App\Vehiculo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ControllerForWorkshops extends Controller
{
    public function getListadoGeneral(Request $request){
        if(!$request->ajax()) return redirect('/');
        $User = User::findorFail(Auth::id());

        $Records = Mantenimiento::select('id','FK_idVehicle','FK_taller','date')
            ->with(['vehiculo','taller'])
            ->where('FK_taller',$User->Taller_id)
            ->where('kms_ini','=',null)
            ->where('date','=',null)
            ->where('idUsuario_Taller','=',null)
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

    public function validarMantenimiento(Request $request){
        if(!$request->ajax()) return redirect('/');
        try
        {
            $mantenimiento = Mantenimiento::findorFail($request->slug);
            $VH = Vehiculo::findOrFail($mantenimiento->FK_idVehicle);
            $mantenimiento->idUsuario_Taller = Auth::id();
            $mantenimiento->date = Carbon::now()->format('Y-m-d');
            $mantenimiento->time = Carbon::now()->format('H:i:s');
            $mantenimiento->kms_ini = $VH->kms_inicial;
            ($VH->type=='PESADO')?$mantenimiento->kms_goal = $mantenimiento->kms_ini+3500 : $mantenimiento->kms_goal = $mantenimiento->kms_ini+6000;
            $mantenimiento->save();
            return response()->json(['code' => '200']);
        }catch(Illuminate\Database\QueryException $ex){
            Log::warning($ex->getMessage());
            Log::info("Request : " + $request);
        }

    }

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
        For some fukin reason this sh*t does the select stament for the relationship but doesnt return anything on json*/
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

    public function getWorkShopsUsers(Request $request){
        $Records = DB::table('tb_users')
            ->select('tb_users.nombre','tb_users.email','tb_users.ultimo_login','tb_users.condicion','tb_talleres.nombre as taller')
            ->join('tb_talleres','tb_talleres.id','=','tb_users.Taller_id')
            ->where('Taller_id','!=',null)
            ->where('role_id','=',2)
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

    public function registerWorkShopsUser(Request $request){
        if(!$request->ajax()) return redirect('/');
        try{
            $user = new User();
            $user->nombre = $request->name;
            $user->nombre_completo = $request->name;
            $user->email = $request->email;
            $user->role_id  = 2;
            $user->password = Hash::make($request->password);
            $user->condicion = 1;
            $user->created_at = now();
            $user->updated_at = now();
            $user->Taller_id = $request->taller;
            $user->save();
        }catch(Illuminate\Database\QueryException $ex){
            Log::warning($ex->getMessage());
            Log::info("Request : " + $request);
        }

    }

    public function get_oil_records(Request $request)
    {
        $query = $request->q;
        $Taller = Auth::user()->Taller_id;
        ($request->desde && $request->hasta) ?
        $Records = DB::table('tb_lubricantes_history')
            ->select('tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.type','tb_lubricantes_history.FK_taller','tb_lubricantes_history.Date_In_Workshop','tb_lubricantes_history.Tipo_Reparacion','tb_lubricantes_history.Qty_Qts','tb_lubricantes_history.Qty_Gals','tb_lubricantes_history.Date_Out_Workshop')
            ->join('tb_vehicles','tb_vehicles.id','=','tb_lubricantes_history.vehicle_id')
            ->where('FK_taller',$Taller)
            ->whereBetween('Date_In_Workshop', [$request->desde, $request->hasta])
            :
        $Records = DB::table('tb_lubricantes_history')
            ->select('tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.type','tb_lubricantes_history.FK_taller','tb_lubricantes_history.Date_In_Workshop','tb_lubricantes_history.Tipo_Reparacion','tb_lubricantes_history.Qty_Qts','tb_lubricantes_history.Qty_Gals','tb_lubricantes_history.Date_Out_Workshop')
            ->join('tb_vehicles','tb_vehicles.id','=','tb_lubricantes_history.vehicle_id')
            ->where('FK_taller',$Taller)
            ->where(function($q) use ($query){
                $q->where('tb_vehicles.Name','LIKE','%'.$query.'%');
                $q->orwhere('tb_vehicles.Plate','LIKE','%'.$query.'%');
                $q->orwhere('tb_vehicles.type','LIKE','%'.$query.'%');
                $q->orwhere('tb_vehicles.type','LIKE','%'.$query.'%');
            });
        ($request->desde && $request->hasta) ? $Records->whereBetween('Date_In_Workshop', [$request->desde, $request->hasta]) : $Records;

        $Records = $Records->orderBy('Date_In_Workshop','DESC')->paginate(50);
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

    public function get_history_records(Request $request)
    {
        $query = $request->q;
        $Taller = Auth::user()->Taller_id;
        ($request->desde && $request->hasta) ?
            $Records = DB::table('tb_mtto_history')
                ->select('tb_users.nombre_completo','tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.type','tb_mtto_history.date','tb_mtto_history.kms_ini','tb_mtto_history.kms_goal')
                ->join('tb_vehicles','tb_vehicles.id','=','tb_mtto_history.FK_idVehicle')
                ->join('tb_users','tb_users.id','=','tb_mtto_history.idUsuario_Taller')
                ->where('FK_taller',$Taller)
                ->whereBetween('tb_mtto_history.date', [$request->desde, $request->hasta])
            :
            $Records = DB::table('tb_mtto_history')
                ->select('tb_users.nombre_completo','tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.type','tb_mtto_history.date','tb_mtto_history.kms_ini','tb_mtto_history.kms_goal')
                ->join('tb_vehicles','tb_vehicles.id','=','tb_mtto_history.FK_idVehicle')
                ->join('tb_users','tb_users.id','=','tb_mtto_history.idUsuario_Taller')
                ->where('FK_taller',$Taller)
                ->where(function($q) use ($query){
                    $q->where('tb_vehicles.Name','LIKE','%'.$query.'%');
                    $q->orwhere('tb_vehicles.Plate','LIKE','%'.$query.'%');
                    $q->orwhere('tb_vehicles.type','LIKE','%'.$query.'%');
                    $q->orwhere('tb_users.nombre_completo','LIKE','%'.$query.'%');
                    $q->orwhere('tb_vehicles.type','LIKE','%'.$query.'%');
                });
        ($request->desde && $request->hasta) ? $Records->whereBetween('tb_mtto_history.date', [$request->desde, $request->hasta]) : $Records;

        $Records = $Records->orderBy('date','DESC')->paginate(50);
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

}
