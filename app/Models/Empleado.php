<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Empleado extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'empleados';
    public $timestamps = false;
    protected $fillable = [
        'cc', 'apellido1', 'apellido2', 'nombre', 'auxilio', 'correo', 'tipo', 'password', 'ciudad', 'horario_id', 'auxiliot', 'ndc', 'area', 'cargo', 'estado'
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

    public function auxilio_extras()
    {
        return $this->hasMany(AuxilioExtras::class, 'empleado_id', 'id');
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
