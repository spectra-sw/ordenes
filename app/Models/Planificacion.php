<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planificacion extends Model
{
    use HasFactory;
    protected $table = 'planificacion';
    public $timestamps = false;
    protected $fillable = [
        'ordenes_id', 'dias_id','cant','und','materiales',
    ];
}
