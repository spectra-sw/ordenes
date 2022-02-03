<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class OcupacionExport implements FromCollection, WithHeadings, ShouldAutoSize
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
            'ID CIA',
            'ID TERCERO',
            'NDC',
            'LAPSO',
            'UNIDADES',
            'CENTRO OPERACION',
            'CENTRO COSTOS',
            'ID PROYECTO',
            'ID UNIDAD DE NEGOCIO',
            'NOTAS'
            
        ];
    }
}
