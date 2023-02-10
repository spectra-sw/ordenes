<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    use HasFactory;
    protected $table = 'jornada';
    public $timestamps = true;
    protected $fillable = [
        'id','jornada_id','user_id','proyecto','fecha','hi','hf','observacion','tipo','revisado_por','fecha_revision','estado'
    ];
}
