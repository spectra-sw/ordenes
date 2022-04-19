<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnaliticasExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    
    protected $datos;
 
    public function __construct($datos= null)
    {
        $this->datos = $datos;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return $this->datos;
    }
    public function headings(): array
    {
        return [
            'Fecha en la que se hizo el reporte',
            'correo electrónico',
            'Día reportado',
            'Area',
            'Funcionario que reporta',
            'ID Proyecto',
            'Tiempo de ocupación en el proyecto(horas)',
            'Clasificación',
            'Actividad',
              								
        ];
    }
}
