<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'habitacion';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['numero', 'situacion', 'piso_id', 'tipohabitacion_id'];

    
}
