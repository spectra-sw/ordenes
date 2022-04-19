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
            'id', 'proyecto','trabajador','motivo','horario_habitual','fecha','hora_entrada',
            'hora_autorizada_salida','observaciones','autorizado_por','director','talento','fecha_vobo_director',
            'fecha_autorizacion','fecha_vobo_talento','created_at','updated_at'
              								
        ];
    }
}
