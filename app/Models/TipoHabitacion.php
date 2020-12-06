<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{

    protected $table = 'tipohabitacion';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'precio'];

    public function habitacion()
    {
        return $this->hasMany(Habitacion::class);
    }
}
