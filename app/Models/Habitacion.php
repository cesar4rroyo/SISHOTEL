<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Habitacion extends Model
{

    protected $table = 'habitacion';
    protected $primaryKey = 'id';
    protected $fillable = ['numero', 'situacion', 'piso_id', 'tipohabitacion_id'];


    public function piso()
    {
        return $this->belongsTo(Piso::class, 'piso_id');
    }
    public function tipohabitacion()
    {
        return $this->belongsTo(TipoHabitacion::class, 'tipohabitacion_id');
    }
}
