<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleados';
    public $timestamps = false;
    protected $fillable = [
        'cc','apellido1','apellido2','nombre','auxilio','correo','tipo','password'
    ];
    
    public function ordenes()
    {
        return $this->hasMany(Orden::class, 'responsable', 'cc');
    }
}
