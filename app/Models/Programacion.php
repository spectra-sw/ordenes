<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Programacion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $table = 'programacion';
    public $timestamps = true;
    protected $fillable = [
        'cc', 'fecha', 'proyecto', 'responsable', 'observacion', 'hi', 'hf', 'grupo', 'extra'
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
