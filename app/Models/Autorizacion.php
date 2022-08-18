<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model
{
    use HasFactory;
    protected $table = 'autorizaciones';
    public $timestamps = true;
    protected $fillable = [
        'id', 'proyecto','trabajador','motivo','horario_habitual','fecha','hora_inicio_extra',
        'hora_fin_extra','total_horas','observaciones','autorizado_rechazado_por','solicitado_por','fecha_autorizacion_rechazo',
        'fecha_solicitud'
    ];

    public function ntrabajador()
    {
        return $this->belongsTo(Empleado::class, 'trabajador', 'cc');
    }
    public function ndirector()
    {
        return $this->belongsTo(Empleado::class, 'autorizado_rechazado_por', 'id');
    }
    public function nsolicita()
    {
        return $this->belongsTo(Empleado::class, 'solicitado_por', 'id');
    }
}

