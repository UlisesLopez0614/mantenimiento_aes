<?php

namespace App\Http\Controllers;

use App\Exports\BatteryReport;
use App\Exports\LubricantesReport;
use App\Exports\OilReport;
use App\Exports\TiresReport;
use App\Lubricantes_History;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Mantenimiento;

use App\Exports\ConsolidadoExport;

class ReporteriaController extends Controller
{
    public function consolidado(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;

        $nombre_reporte = 'CONSOLIDADO-MANTENIMIENTOS.xlsx';

        $mantenimientos = Mantenimiento::select('tb_mtto_history.*', 'vehicles.idAVL', 'vehicles.Name', 'vehicles.Plate',
                                                'vehicles.Fleet', 'vehicles.type', 'tb_talleres.nombre as taller',
                                                'tb_tipo_mttos.nombre as tipomtto')
                                        ->join('vehicles', 'vehicles.id', '=', 'tb_mtto_history.FK_idVehicle')
                                        ->join('tb_tipo_mttos', 'tb_tipo_mttos.id', '=', 'tb_mtto_history.FK_tipoMtto')
                                        ->join('tb_talleres', 'tb_talleres.id', '=', 'tb_mtto_history.FK_taller')
                                        ->whereBetween('tb_mtto_history.date', [$desde, $hasta])
                                        ->get();

        Excel::store(new ConsolidadoExport($mantenimientos, $desde, $hasta), $nombre_reporte, 'public');

    }

    public function consolidadoDescargar(Request $request)
    {
        $nombre_reporte = 'CONSOLIDADO-MANTENIMIENTOS.xlsx';
        $file = storage_path() . '/app/public/' . $nombre_reporte;

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return response()->download($file, $nombre_reporte, $headers);
    }

    //Lubricantes
    public function consolidadoLubricantes(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;

        $nombre_reporte = 'CONSOLIDADO_MANTENIMIENTOS_LUBRICANTES.xlsx';

        $mantenimientos = DB::table('tb_lubricantes_history')
            ->select('vehicles.Name','vehicles.Plate','vehicles.Fleet','vehicles.Area','vehicles.type','vehicles.kms_inicial','tb_talleres.nombre',
                'tb_lubricantes_history.Date_Out_Fleet','tb_lubricantes_history.Date_In_Workshop','tb_lubricantes_history.Date_Out_Workshop','tb_lubricantes_history.Date_In_Fleet','tb_lubricantes_history.Qty_Qts','tb_lubricantes_history.Qty_Gals','tb_lubricantes_history.Amount','tb_lubricantes_history.Tipo_Reparacion','tb_lubricantes_history.Ciclo_Mto')
            ->Join('vehicles','vehicles.id', '=', 'tb_lubricantes_history.vehicle_id')
            ->Join('tb_talleres','tb_talleres.id','=','tb_lubricantes_history.FK_taller')
            ->whereBetween('Date_Out_Fleet', [date($desde), date($hasta)])
            ->get();
        Excel::store(new OilReport($mantenimientos, $desde, $hasta), $nombre_reporte, 'public');

    }

    public function DescargarReporteLubricantes(Request $request)
    {
        $nombre_reporte = 'CONSOLIDADO_MANTENIMIENTOS_LUBRICANTES.xlsx';
        $file = storage_path() . '/app/public/' . $nombre_reporte;
        $headers = ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',];
        return response()->download($file, $nombre_reporte, $headers);
    }
    //Baterias
    public function consolidadoBaterias(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;

        $nombre_reporte = 'CONSOLIDADO-MANTENIMIENTOS_BATERIAS.xlsx';

        $mantenimientos = DB::table('tb_baterias_history')
            ->select('vehicles.Name','vehicles.Plate','vehicles.Fleet','vehicles.Area','vehicles.type','vehicles.kms_inicial',
                'tb_baterias_history.Tipo_Bateria','tb_baterias_history.mecanico','tb_baterias_history.Installation_Date','tb_baterias_history.Qty','tb_baterias_history.Numero_Aviso','tb_baterias_history.Orden_Trabajo','tb_baterias_history.Amount','tb_baterias_history.Disposicion_Final')
            ->Join('vehicles','vehicles.id', '=', 'tb_baterias_history.vehicle_id')
            ->whereBetween('Installation_Date', [date($desde), date($hasta)])
            ->get();
        Excel::store(new BatteryReport($mantenimientos, $desde, $hasta), $nombre_reporte, 'public');

    }

    public function DescargarReporteBaterias(Request $request)
    {
        $nombre_reporte = 'CONSOLIDADO-MANTENIMIENTOS_BATERIAS.xlsx';
        $file = storage_path() . '/app/public/' . $nombre_reporte;

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return response()->download($file, $nombre_reporte, $headers);
    }
    //Llantas
    public function consolidadoLlantas(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;

        $nombre_reporte = 'CONSOLIDADO-MANTENIMIENTOS_LLANTAS.xlsx';

        $mantenimientos = DB::table('tb_llantas_history')
            ->select('vehicles.Name','vehicles.Plate','vehicles.Fleet','vehicles.Area','vehicles.type','vehicles.kms_inicial',
                'tb_llantas_history.Tipo_Llanta','tb_llantas_history.Installation_Date','tb_llantas_history.Installation_Date','tb_llantas_history.Qty','tb_llantas_history.Numero_Aviso','tb_llantas_history.Orden_Trabajo','tb_llantas_history.Amount','tb_llantas_history.Disposicion_Final')
            ->Join('vehicles','vehicles.id', '=', 'tb_llantas_history.vehicle_id')
            ->whereBetween('Installation_Date', [date($desde), date($hasta)])
            ->get();

        Excel::store(new TiresReport($mantenimientos, $desde, $hasta), $nombre_reporte, 'public');

    }

    public function DescargarReporteLlantas(Request $request)
    {
        $nombre_reporte = 'CONSOLIDADO-MANTENIMIENTOS_LLANTAS.xlsx';
        $file = storage_path() . '/app/public/' . $nombre_reporte;

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return response()->download($file, $nombre_reporte, $headers);
    }
}
