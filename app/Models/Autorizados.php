<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizados extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'autorizados_proyectos';
    protected $fillable = [
        'id','proyecto','empleado_id'
    ];
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id');
    }
    public function proyectoinfo()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto', 'codigo');
    }
}
