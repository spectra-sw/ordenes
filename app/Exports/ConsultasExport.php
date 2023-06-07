<?php

namespace App\Exports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ConsultasExport implements FromView
{

    protected $datos;

    public function __construct($datos= null)
    {
        $this->datos = $datos;
    }

    public function view(): View
    {

        return view('tablaconsultaExport',
        [
            'jornadas' => $this->datos
        ]);

    }
}
