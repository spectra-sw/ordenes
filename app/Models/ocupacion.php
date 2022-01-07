<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ocupacion extends Model
{
    use HasFactory;
    protected $table = 'ocupacion';
  
    protected $fillable = [
       'cc','dia','area','actividad','proyecto','horas','minutos'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cc', 'cc');
    }
    public function narea()
    {
        return $this->belongsTo(Area::class, 'area', 'id');
    }
    public function nactividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad', 'id');
    }
}
