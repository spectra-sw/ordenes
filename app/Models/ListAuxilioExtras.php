<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ListAuxilioExtras extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'list_auxilio_extras';
    public $timestamps = false;
    protected $fillable = [
        'id', 'name', 'code'
    ];

    public function auxilio_extras()
    {
        return $this->hasMany(AuxilioExtras::class, 'list_auxilio_extra_id', 'id');
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
