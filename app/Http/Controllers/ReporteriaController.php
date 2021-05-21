<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
}
