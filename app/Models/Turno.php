<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Turno extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $table = 'turnos';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'fecha_inicio', 'fecha_fin', 'hora_inicio', 'hora_fin', 'almuerzo'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'user_id', 'id');
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
