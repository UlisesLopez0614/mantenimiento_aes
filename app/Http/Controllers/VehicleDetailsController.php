<?php

namespace App\Http\Controllers;

use App\Baterias_History;
use App\Detalles_Vehiculos;
use App\Llantas_History;
use App\Lubricantes_History;
use App\Vehiculo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Exception;

class VehicleDetailsController extends Controller
{
    //Baterias
    public function getBatteryDetails(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
            $buscar = $request->buscar;
            $criterio = $request->criterio;
            $desde = $request->desde;
            $hasta = $request->hasta;
            $db = Vehiculo::where('estado', 1)->toSql();
            $vehicles = Vehiculo::select('tb_vehicles.id')->where('estado', 1)->get();

            $arreglo_vehiculos = array();

            foreach($vehicles as $item){
                $arreglo_vehiculos[] = $item->id;
            }

        if($desde != null && $hasta != null){
            $Records =  Detalles_Vehiculos::with(['vehiculo','llantas'])
                ->whereHas('vehiculo', function ($query) use ($buscar) {
                    $query->where('Name','LIKE','%'.$buscar.'%')
                        ->orwhere('Plate','LIKE','%'.$buscar.'%')
                        ->orwhere('Fleet','LIKE','%'.$buscar.'%')
                        ->orwhere('Area','LIKE','%'.$buscar.'%')
                        ->orwhere('type','LIKE','%'.$buscar.'%');
                })
                ->orWhereHas('baterias', function ($query) use ($desde,$hasta,$buscar) {
                    $query->whereBetween('Installation_Date', [$desde, $hasta])
                        ->where('Tipo_Bateria','LIKE','%'.$buscar.'%')
                        ->orwhere('mecanico','LIKE','%'.$buscar.'%')
                        ->orwhere('Numero_Aviso','LIKE','%'.$buscar.'%')
                        ->orwhere('Orden_Trabajo','LIKE','%'.$buscar.'%')
                        ->orwhere('Disposicion_Final','LIKE','%'.$buscar.'%');
                })
                ->whereIn('vehicle_id', $arreglo_vehiculos)
                ->paginate(50);
        }
        else{
            $Records =  Detalles_Vehiculos::with(['vehiculo','baterias'])
                ->whereHas('vehiculo', function ($query) use ($buscar) {
                    $query->where('Name','LIKE','%'.$buscar.'%')
                        ->orwhere('Plate','LIKE','%'.$buscar.'%')
                        ->orwhere('Fleet','LIKE','%'.$buscar.'%')
                        ->orwhere('Area','LIKE','%'.$buscar.'%')
                        ->orwhere('type','LIKE','%'.$buscar.'%');
                })
                ->orWhereHas('baterias', function ($query) use ($buscar) {
                    $query->where('Tipo_Bateria','LIKE','%'.$buscar.'%')
                        ->orwhere('mecanico','LIKE','%'.$buscar.'%')
                        ->orwhere('Numero_Aviso','LIKE','%'.$buscar.'%')
                        ->orwhere('Orden_Trabajo','LIKE','%'.$buscar.'%')
                        ->orwhere('Disposicion_Final','LIKE','%'.$buscar.'%');
                })
                ->whereIn('vehicle_id', $arreglo_vehiculos)
                ->paginate(50);
        }

            $Records =  Detalles_Vehiculos::with(['vehiculo','baterias'])
                ->whereIn('vehicle_id', $arreglo_vehiculos)
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
                'principales' => $Records

            ];

    }

    public function getBatteryHistory(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $mantenimientos = Baterias_History::where('vehicle_id',$request->vehiculo)->get();
            //dd($mantenimientos);
        }else{
            //$talleres = Taller::where($criterio, 'like', '%' . $buscar . '%')->orderBy('nombre', 'asc')->paginate(5);
        }

        return [

            'mantenimientos' => $mantenimientos

        ];
    }

    public function registerBatteryRecord(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        try
        {

            $mantenimiento = new Baterias_History();
            $mantenimiento->vehicle_id = $request->vehiculo;
            $mantenimiento->Tipo_Bateria = $request->tipo_bateria;
            $mantenimiento->mecanico = $request->mecanico;
            $mantenimiento->Qty = $request->qty_battery;
            $mantenimiento->Amount = $request->amount;
            $mantenimiento->Numero_Aviso = $request->numero_aviso;
            $mantenimiento->Orden_Trabajo = $request->orden_trabajo;
            $mantenimiento->Disposicion_Final = $request->disposicion_final;
            $mantenimiento->Installation_Date = $request->Installation_Date;
            $mantenimiento->created_at = now();
            $mantenimiento->updated_at = now();
            $mantenimiento->save();

            $Vehicle_Data = Detalles_Vehiculos::where('vehicle_id',$request->vehiculo)->first();
            $Vehicle_Data->bateria_id = $mantenimiento->id;
            $Vehicle_Data->save();
        }
        catch(Illuminate\Database\QueryException $ex){
            Log::warning($ex->getMessage());
            Log::info("Request : " + $request);
        }

    }
    //Baterias

    // LLantas
    public function getTireDetails(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $desde = $request->desde;
        $hasta = $request->hasta;
        $vehicles = Vehiculo::select('tb_vehicles.id')->where('estado', 1)->get();

        $arreglo_vehiculos = array();

        foreach($vehicles as $item){
            $arreglo_vehiculos[] = $item->id;
        }

        if($desde != null && $hasta != null){
            $Records =  Detalles_Vehiculos::with(['vehiculo','llantas'])
                ->whereHas('vehiculo', function ($query) use ($buscar) {
                    $query->where('Name','LIKE','%'.$buscar.'%')
                        ->orwhere('Plate','LIKE','%'.$buscar.'%')
                        ->orwhere('Fleet','LIKE','%'.$buscar.'%')
                        ->orwhere('Area','LIKE','%'.$buscar.'%')
                        ->orwhere('type','LIKE','%'.$buscar.'%');
                })
                ->orWhereHas('llantas', function ($query) use ($desde,$hasta,$buscar) {
                    $query->whereBetween('Installation_Date', [$desde, $hasta])
                        ->where('Tipo_Bateria','LIKE','%'.$buscar.'%')
                        ->orwhere('mecanico','LIKE','%'.$buscar.'%')
                        ->orwhere('Numero_Aviso','LIKE','%'.$buscar.'%')
                        ->orwhere('Orden_Trabajo','LIKE','%'.$buscar.'%')
                        ->orwhere('Disposicion_Final','LIKE','%'.$buscar.'%');
                })
                ->whereIn('vehicle_id', $arreglo_vehiculos)
                ->paginate(50);
        }
        else{
            $Records =  Detalles_Vehiculos::with(['vehiculo','llantas'])
                ->whereHas('vehiculo', function ($query) use ($buscar) {
                    $query->where('Name','LIKE','%'.$buscar.'%')
                        ->orwhere('Plate','LIKE','%'.$buscar.'%')
                        ->orwhere('Fleet','LIKE','%'.$buscar.'%')
                        ->orwhere('Area','LIKE','%'.$buscar.'%')
                        ->orwhere('type','LIKE','%'.$buscar.'%');
                })
                ->whereIn('vehicle_id', $arreglo_vehiculos)
                ->paginate(50);
        }

        return [
            'pagination' => [
                'total'         => $Records->total(),
                'current_page'  => $Records->currentPage(),
                'per_page'      => $Records->perPage(),
                'last_page'     => $Records->lastPage(),
                'from'          => $Records->firstItem(),
                'to'            => $Records->lastItem(),
            ],
            'principales' => $Records

        ];

    }

    public function getTireHistory(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $mantenimientos = Llantas_History::where('vehicle_id',$request->vehiculo)->get();
        return ['mantenimientos' => $mantenimientos];
    }

    public function registerTireRecord(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        try
        {
            $mantenimiento = new Llantas_History();
            $mantenimiento->vehicle_id = $request->vehiculo;
            $mantenimiento->Tipo_Llanta = $request->tipo_llanta;
            $mantenimiento->Qty = $request->qty_llantas;
            $mantenimiento->Amount = $request->amount;
            $mantenimiento->Numero_Aviso = $request->numero_aviso;
            $mantenimiento->Orden_Trabajo = $request->orden_trabajo;
            $mantenimiento->Disposicion_Final = $request->disposicion_final;
            $mantenimiento->Installation_Date = $request->Installation_Date;
            $mantenimiento->created_at = now();
            $mantenimiento->updated_at = now();
            $mantenimiento->save();

            $Vehicle_Data = Detalles_Vehiculos::where('vehicle_id',$request->vehiculo)->first();
            $Vehicle_Data->llantas_id = $mantenimiento->id;
            $Vehicle_Data->save();
        }
        catch(Illuminate\Database\QueryException $ex){
            Log::warning($ex->getMessage());
            Log::info("Request : " + $request);
        }

    }
    //Lubricantes
    public function getOilDetails(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $desde = $request->desde;
        $hasta = $request->hasta;
        $vehicles = Vehiculo::select('tb_vehicles.id')->where('estado', 1)->get();

        $arreglo_vehiculos = array();

        foreach($vehicles as $item){
            $arreglo_vehiculos[] = $item->id;
        }
        if($desde != null && $hasta != null){
            $Records = DB::table('tb_detalles_vehicles')
                ->select('tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.Fleet','tb_vehicles.Area','tb_vehicles.type','tb_vehicles.kms_inicial','tb_talleres.nombre',
                    'tb_detalles_vehicles.vehicle_id','tb_detalles_vehicles.lubricante_id',
                    'tb_lubricantes_history.Date_Out_Fleet','tb_lubricantes_history.Date_In_Workshop','tb_lubricantes_history.Date_Out_Workshop','tb_lubricantes_history.Date_In_Fleet','tb_lubricantes_history.Qty_Qts','tb_lubricantes_history.Qty_Gals','tb_lubricantes_history.Amount','tb_lubricantes_history.Tipo_Reparacion','tb_lubricantes_history.Ciclo_Mto')
                ->leftJoin('tb_lubricantes_history','tb_lubricantes_history.id', '=', 'tb_detalles_vehicles.lubricante_id')
                ->leftJoin('tb_vehicles','tb_vehicles.id', '=', 'tb_detalles_vehicles.vehicle_id')
                ->leftJoin('tb_talleres','tb_talleres.id','=', 'tb_lubricantes_history.FK_taller')
                ->whereBetween('tb_lubricantes_history.Date_Out_Fleet',[$desde,$hasta])
                ->where('tb_vehicles.Name', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_vehicles.Plate', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_vehicles.Fleet', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_vehicles.Area', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_vehicles.type', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_vehicles.kms_inicial', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_talleres.nombre', 'LIKE','%'.$buscar.'%')
                ->paginate(50);
            /*  Consulta de Datos usando Eloquent pero fallan al momento de realizar una busqueda debido al tipo de datos que se manejan
            $Records =  Detalles_Vehiculos::with(['vehiculo','lubricantes','lubricantes.taller'])
                ->orwhere('vehicle_id', 'LIKE','%'.$buscar.'%')
                ->whereHas('lubricantes', function ($query) use ($desde,$hasta,$buscar) {
                    $query->whereBetween('Date_Out_Fleet', [$desde, $hasta])
                    ->where('Date_In_Workshop','LIKE','%'.$buscar.'%')
                    ->orwhere('Date_Out_Workshop','LIKE','%'.$buscar.'%')
                    ->orwhere('Qty_Gals','LIKE','%'.$buscar.'%')
                    ->orwhere('Qty_Qts','LIKE','%'.$buscar.'%');
                })
                ->whereHas('lubricantes.taller', function ($query) use ($buscar) {
                    $query->where('nombre','LIKE','%'.$buscar.'%');
                })
                ->whereHas('vehiculo', function ($query) use ($buscar) {
                    $query->where('Name','LIKE','%'.$buscar.'%')
                        ->orwhere('Plate','LIKE','%'.$buscar.'%')
                        ->orwhere('Fleet','LIKE','%'.$buscar.'%')
                        ->orwhere('Area','LIKE','%'.$buscar.'%')
                        ->orwhere('type','LIKE','%'.$buscar.'%');
                })
                ->whereIn('vehicle_id', $arreglo_vehiculos)
                ->paginate(50);*/
        }
        else{
                $Records = DB::table('tb_detalles_vehicles')
                ->select('tb_vehicles.Name','tb_vehicles.Plate','tb_vehicles.Fleet','tb_vehicles.Area','tb_vehicles.type','tb_vehicles.kms_inicial','tb_talleres.nombre',
                    'tb_detalles_vehicles.vehicle_id','tb_detalles_vehicles.lubricante_id',
                    'tb_lubricantes_history.Date_Out_Fleet','tb_lubricantes_history.Date_In_Workshop','tb_lubricantes_history.Date_Out_Workshop','tb_lubricantes_history.Date_In_Fleet','tb_lubricantes_history.Qty_Qts','tb_lubricantes_history.Qty_Gals','tb_lubricantes_history.Amount','tb_lubricantes_history.Tipo_Reparacion','tb_lubricantes_history.Ciclo_Mto')
                ->leftJoin('tb_lubricantes_history','tb_lubricantes_history.id', '=', 'tb_detalles_vehicles.lubricante_id')
                ->leftJoin('tb_vehicles','tb_vehicles.id', '=', 'tb_detalles_vehicles.vehicle_id')
                ->leftJoin('tb_talleres','tb_talleres.id','=', 'tb_lubricantes_history.FK_taller')
                ->orwhere('tb_vehicles.Name', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_vehicles.Plate', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_vehicles.Fleet', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_vehicles.Area', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_vehicles.type', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_vehicles.kms_inicial', 'LIKE','%'.$buscar.'%')
                ->orwhere('tb_talleres.nombre', 'LIKE','%'.$buscar.'%')
                ->paginate(50);
/*
            $Records =  Detalles_Vehiculos::with(['vehiculo','lubricantes','lubricantes.taller'])
                ->orwhere('vehicle_id', 'LIKE','%'.$buscar.'%')
                ->whereHas('lubricantes', function ($query) use ($buscar) {
                    $query->where('Date_In_Workshop','LIKE','%'.$buscar.'%')
                        ->orwhere('Date_Out_Workshop','LIKE','%'.$buscar.'%')
                        ->orwhere('Qty_Gals','LIKE','%'.$buscar.'%')
                        ->orwhere('Qty_Qts','LIKE','%'.$buscar.'%');
                })
                ->whereHas('lubricantes.taller', function ($query) use ($buscar) {
                    $query->where('nombre','LIKE','%'.$buscar.'%');
                })
                ->whereHas('vehiculo', function ($query) use ($buscar) {
                    $query->where('Name','LIKE','%'.$buscar.'%')
                        ->orwhere('Plate','LIKE','%'.$buscar.'%')
                        ->orwhere('Fleet','LIKE','%'.$buscar.'%')
                        ->orwhere('Area','LIKE','%'.$buscar.'%')
                        ->orwhere('type','LIKE','%'.$buscar.'%');
                })
                ->whereIn('vehicle_id', $arreglo_vehiculos)
                ->paginate(50);*/
        }

        return [
            'pagination' => [
                'total'         => $Records->total(),
                'current_page'  => $Records->currentPage(),
                'per_page'      => $Records->perPage(),
                'last_page'     => $Records->lastPage(),
                'from'          => $Records->firstItem(),
                'to'            => $Records->lastItem(),
            ],
            'principales' => $Records

        ];

    }

    public function getOilHistory(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $mantenimientos = Lubricantes_History::with('taller')->where('vehicle_id',$request->vehiculo)->get();
        return ['mantenimientos' => $mantenimientos];
    }

    public function registerOilRecord(Request $request)
    {
        if(!$request->ajax()) return redirect('/');


        try
        {
            $mantenimiento = new Lubricantes_History();
            $mantenimiento->vehicle_id = $request->vehiculo;
            $mantenimiento->Date_Out_Fleet = $request->Date_Out_Fleet;
            $mantenimiento->FK_Taller = $request->taller;
            $mantenimiento->created_at = now();
            $mantenimiento->updated_at = now();
            $mantenimiento->save();

            $Vehicle_Data = Detalles_Vehiculos::firstOrCreate([
                'vehicle_id' => $request->vehiculo
            ]);
            $Vehicle_Data->lubricante_id=$mantenimiento->id;
            if(!$Vehicle_Data->created_at){$Vehicle_Data->created_at = now();}
            $Vehicle_Data->updated_at =now();
            $Vehicle_Data->save();
        }
        catch(Illuminate\Database\QueryException $ex){
            Log::warning($ex->getMessage());
            Log::info("Request : " + $request);
        }

    }

    public function updateOilRecord(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try
        {
            $mantenimiento = Lubricantes_History::findOrFail($request->id);
            $mantenimiento->Date_In_Fleet= $request->Date_In;
            $mantenimiento->Amount = $request->Qty;
            $mantenimiento->updated_at = now();
            $mantenimiento->save();
        }
        catch(Illuminate\Database\QueryException $ex){
            Log::warning($ex->getMessage());
            Log::info("Request : " + $request);
        }
    }

    public function finalUpdateOilRecord(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try
        {
            $Vehicle_Data = Detalles_Vehiculos::where('vehicle_id',$request->vehiculo);
            $mantenimiento = Lubricantes_History::findorFail($Vehicle_Data->lubricante_id);
            $mantenimiento->Date_In_Fleet = $request->Date_Out_Fleet;
            $mantenimiento->updated_at = now();
            $mantenimiento->save();

            if(!$Vehicle_Data->created_at){$Vehicle_Data->created_at = now();}
            $Vehicle_Data->updated_at =now();
            $Vehicle_Data->save();
        }
        catch(Illuminate\Database\QueryException $ex){
            Log::warning($ex->getMessage());
            Log::info("Request : " + $request);
        }
    }

}
