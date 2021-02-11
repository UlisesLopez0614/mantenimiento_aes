<?php

namespace App\Exports;

use App\Mantenimiento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class ConsolidadoExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
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

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        //dd($this->arrayMantenimiento);
        return view('reportes.consolidado-mantenimiento', [ 
            'arrayMantenimiento' => $this->arrayMantenimiento,
            'desde' => $this->desde,
            'hasta' => $this->hasta
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'HISTORIAL MANTENIMIENTOS';
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function(AfterSheet $event) {
                
                $cellRange = 'A1:I' .((string) count($this->arrayMantenimiento) + 3); // All headers

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

                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray)->getActiveSheet()->setAutoFilter('A3:I3');
                $event->sheet->getDelegate()->getStyle('A1:I3')->getFont()->setSize(14)->setBold(true);
                
            },
        ];
    }
}
