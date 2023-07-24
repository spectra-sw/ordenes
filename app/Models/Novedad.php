<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Novedad extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    use HasFactory;
    protected $table = 'novedades';
    public $timestamps = false;
    protected $fillable = [
        'id', 'cc', 'horas', 'periodo'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'cc', 'cc');
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
