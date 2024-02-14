<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Jornada extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'jornada';
    public $timestamps = true;
    protected $fillable = [
        'id', 'jornada_id', 'user_id', 'proyecto', 'fecha',
        'hi', 'hf', 'duracion', 'fechaf', 'almuerzo', 'observacion',
        'tipo', 'revisado_por', 'fecha_revision', 'estado'
    ];
    public function trabajador()
    {
        return $this->belongsTo(Empleado::class, 'user_id', 'id');
    }
    public function revisado()
    {
        return $this->belongsTo(Empleado::class, 'revisado_por', 'id');
    }
    public function proyectoinfo()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto', 'codigo');
    }
    public function cdcinfo()
    {
        return $this->belongsTo(Cdc::class, 'proyecto', 'codigo');
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
