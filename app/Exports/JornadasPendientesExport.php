<?php

namespace App\Exports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class JornadasPendientesExport implements FromView
{

    protected $jornadas_pendientes;
    protected $fechas_columnas;

    public function __construct($jornadas_pendientes = null, $fechas_columnas = null)
    {
        $this->jornadas_pendientes = $jornadas_pendientes;
        $this->fechas_columnas = $fechas_columnas;
    }

    public function view(): View
    {
        return view(
            'jornadasPendientesExport',
            [
                'jornadas_pendientes' => $this->jornadas_pendientes,
                'fechas_columnas' => $this->fechas_columnas
            ]
        );
    }
}
