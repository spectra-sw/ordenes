<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;
    protected $table = 'ordenes';
    protected $fillable = [
        'proyecto', 'fecha_inicio','fecha_final','responsable','cliente',
        'area_trabajo','contacto','tipo','objeto','observaciones','autorizada_por','creada_por'
    ];

    public function empleado()
    {
    return $this->belongsTo(Empleado::class, 'responsable', 'cc');
    }

}
