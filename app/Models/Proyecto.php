<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Proyecto extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $table = 'proyectos';
    public $timestamps = false;
    protected $fillable = [
        'codigo', 'descripcion', 'cliente_id', 'sistema', 'ciudad', 'subportafolio', 'director', 'lider',
        'creado_por', 'creacion', 'registro'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
    public function ndirector()
    {
        return $this->belongsTo(Empleado::class, 'director', 'id');
    }
    public function nlider()
    {
        return $this->belongsTo(Empleado::class, 'lider', 'id');
    }
    public function cdc()
    {
        return $this->belongsTo(Cdc::class, 'codigo', 'codigo');
    }
    public function jornadas()
    {
        return $this->hasMany(Jornada::class, 'codigo', 'proyecto');
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
