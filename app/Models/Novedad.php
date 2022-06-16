<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Novedad extends Model
{
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
}
