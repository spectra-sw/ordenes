<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuxilioExtras extends Model
{
    use HasFactory;
    protected $table = 'auxilio_extras';
    public $timestamps = false;
    protected $fillable = [
        'id','empleado_id','valor','list_auxilio_extra_id',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id');
    }

    public function list_auxilio_extra()
    {
        return $this->belongsTo(ListAuxilioExtras::class, 'list_auxilio_extra_id', 'id');
    }
}
