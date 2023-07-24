<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Planificacion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'planificacion';
    public $timestamps = false;
    protected $fillable = [
        'ordenes_id', 'dias_id', 'cant', 'und', 'materiales',
    ];

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
