<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Autorizacion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
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
    public function estado(){
        if ($this->fecha_autorizacion_rechazo){
            if ($this->observaciones !="RECHAZADA"){
                return "APROBADA";
            }
            else{
                return "RECHAZADA";
            }
        }
        else{
            return "PENDIENTE";
        }
    }

    public function transformAudit(array $data): array
    {
        $user_id = session('user');
        if ($user_id) {
            $data['user_id'] = session('user');
            $data['user_type'] = Empleado::class;
        }

        return $data;
    }
}

