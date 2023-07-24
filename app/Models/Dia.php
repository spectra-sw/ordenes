<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Dia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'dias';
    public $timestamps = false;
    protected $fillable = [
        'ordenes_id', 'fecha', 'observacion',
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
