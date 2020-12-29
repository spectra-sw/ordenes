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
            'CÓDIGO DEL EMPLEADO',
            'SUCURSAL',
            'CÓDIGO DEL CONCEPTO',
            'CENTRO DE OPERACIÓN',
            'CENTRO DE COSTO',
            'FECHA MOVIMIENTO',
            'HORAS',
            'VALOR',
            'CANTIDAD',
            'PROYECTO',
            'NUMERO DE CONTRATO DEL EMPLEADO',
            'UNIDAD DE NEGOCIO',
            'FECHA DE CAUSACIÓN',
            'NUMERO DE CUOTA',
            'NOTAS'
            
        ];
    }
}
