<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAuxilioExtras extends Model
{
    use HasFactory;
    protected $table = 'list_auxilio_extras';
    public $timestamps = false;
    protected $fillable = [
        'id','name', 'code'
    ];

    public function auxilio_extras()
    {
        return $this->hasMany(AuxilioExtras::class, 'list_auxilio_extra_id', 'id');
    }
}
