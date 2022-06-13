<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';
    public $timestamps = false;
    protected $fillable = [
         'codigo','descripcion','cliente_id','sistema','ciudad', 'subportafolio', 'director', 'lider',
         'creado_por','creacion'
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
    public function cdc(){
        return $this->belongsTo(Cdc::class,'codigo','codigo');
    }
}
