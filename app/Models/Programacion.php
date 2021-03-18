<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    use HasFactory;

    protected $table = 'programacion';
    public $timestamps = false;
    protected $fillable = [
         'cc','fecha','proyecto','responsable','observacion'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cc', 'cc');
    }
    public function datosproyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto', 'codigo');
    }
    public function datosresponsable()
    {
        return $this->belongsTo(Empleado::class, 'responsable', 'id');
    }
}
