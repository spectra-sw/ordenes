<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExtraExport implements FromCollection, WithHeadings, ShouldAutoSize
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
            'CC','NOMBRE','MOTIVO','FECHA','HOTARIO HABITUAL','HORA INICIO EXTRA','HORA FIN EXTRA',
            'TOTAL HORAS','PROYECTO','SOLICITADO POR','FECHA SOLICITUD','AUTORIZADO/RECHAZADO POR',
            'FECHA AUTORIZACIO/RECHAZO','ESTADO'
        ];
        
    }
}
