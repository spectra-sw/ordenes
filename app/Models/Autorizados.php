<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Autorizados extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    public $timestamps = false;
    protected $table = 'autorizados_proyectos';
    protected $fillable = [
        'id', 'proyecto', 'empleado_id'
    ];
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id');
    }
    public function proyectoinfo()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto', 'codigo');
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
