<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class BatteryReport implements FromView, ShouldAutoSize, WithTitle, WithEvents
{
    protected $arrayMantenimiento;
    protected $desde;
    protected $hasta;

    public function __construct($arrayMantenimiento, $desde, $hasta)
    {
        $this->arrayMantenimiento = $arrayMantenimiento;
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    public function view(): View
    {
        return view('reportes.reporte_baterias', [
            'arrayMantenimiento' => $this->arrayMantenimiento,
            'desde' => $this->desde,
            'hasta' => $this->hasta
        ]);
    }

    public function title(): string
    {
        return 'HISTORIAL MANTENIMIENTOS BATERIAS';
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:L' .((string) count($this->arrayMantenimiento) + 4); //
                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $styleArray2 = [
                    'font' => [
                        'bold' => true,
                    ],
                ];
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray)->getActiveSheet()->setAutoFilter('A4:L4');
                $event->sheet->getDelegate()->getStyle('A1:L4')->getFont()->setSize(14)->setBold(true);
            },
        ];
    }
}
