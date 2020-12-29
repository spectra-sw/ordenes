<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NominaExport implements FromCollection, WithHeadings, ShouldAutoSize
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
            'Código','Concepto',
            'Centro de op',
            'Centro de costo',
            'Fecha',
            'Horas',
            'Valor',
            '','','','',
            'Unidad'
            
        ];
    }
}
