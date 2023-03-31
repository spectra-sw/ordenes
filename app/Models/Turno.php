<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;
   
    protected $table = 'turnos';
    public $timestamps = false;
    protected $fillable = [
        'user_id','fecha_inicio', 'fecha_fin','hora_inicio','hora_fin','almuerzo'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'user_id', 'id');
    }
}
