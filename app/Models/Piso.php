<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piso extends Model
{

    protected $table = 'piso';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];

    public function habitacion()
    {
        return $this->hasMany(Habitacion::class);
    }
}
