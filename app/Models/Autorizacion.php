<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model
{
    use HasFactory;
    protected $table = 'autorizaciones';
    public $timestamps = false;
    protected $fillable = [
        'id', 'proyecto','trabajador','motivo','horario_habitual','fecha','hora_entrada',
        'hora_autorizada_salida','observaciones','autorizado_por','director','talento','fecha_vobo_director',
        'fecha_autorizacion','fecha_vobo_talento'
    ];

    public function ntrabajador()
    {
        return $this->belongsTo(Empleado::class, 'trabajador', 'cc');
    }
    public function ndirector()
    {
        return $this->belongsTo(Empleado::class, 'director', 'id');
    }
    public function nautorizado()
    {
        return $this->belongsTo(Empleado::class, 'autorizado_por', 'id');
    }
}

