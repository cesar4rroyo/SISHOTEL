<?php

namespace App\Models;

use App\Models\Procesos\Caja;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{

    protected $table = 'concepto';

    protected $primaryKey = 'id';

    protected $fillable = ['nombre', 'tipo'];

    public function caja()
    {
        return $this->hasMany(Caja::class, 'concepto_id');
    }
}
