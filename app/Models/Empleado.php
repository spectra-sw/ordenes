<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleados';
    public $timestamps = false;
    protected $fillable = [
        'cc','apellido1','apellido2','nombre','auxilio','correo','tipo','password','ciudad','horario_id','auxiliot','ndc','area','cargo','estado'
    ];

    public function ordenes()
    {
        return $this->hasMany(Orden::class, 'responsable', 'cc');
    }
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id', 'id');
    }
    public function horas()
    {
        return $this->hasMany(Hora::class, 'trabajdor', 'cc');
    }
    public function narea()
    {
        return $this->belongsTo(Area::class, 'area', 'id');
    }
    public function ncargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo', 'id');
    }
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }
    public function magicLinks()
    {
        return $this->hasMany(MagicLink::class);
    }
}
