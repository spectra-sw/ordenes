<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejecucion extends Model
{
    use HasFactory;
    protected $table = 'ejecucion';
    public $timestamps = false;
    protected $fillable = [
        'ordenes_id', 'dias_id','cant','und','observacion',
    ];
}
