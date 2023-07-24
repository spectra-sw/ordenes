<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ocupacion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'ocupacion';

    protected $fillable = [
        'cc', 'dia', 'area', 'actividad', 'proyecto', 'horas', 'minutos'
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
