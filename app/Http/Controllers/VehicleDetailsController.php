<?php

namespace App\Http\Controllers;

use App\Baterias_History;
use App\Detalles_Vehiculos;
use App\Llantas_History;
use App\Vehiculo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
        $db = Vehiculo::where('estado', 1)->toSql();
        $vehicles = Vehiculo::select('tb_vehicles.id')->where('estado', 1)->get();

        $arreglo_vehiculos = array();

        foreach($vehicles as $item){
            $arreglo_vehiculos[] = $item->id;
        }

        $Records =  Detalles_Vehiculos::with(['vehiculo','llantas'])
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
    //Llantas
}
